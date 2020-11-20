<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Account;
use app\models\Rotation;
use app\models\Roles;
use app\models\Region;
use app\models\SupportGroup;
use app\models\SupportGroupShift;
use app\models\SplunkDate;
use app\models\Zone;
use app\models\Setting;
use yii\helpers\Url;
use yii\helpers\BaseFileHelper;
use yii\db\Expression;
use yii\db\Query;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

     /**
     * P1 Shift.
     *
     * @return string
     */
    public function actionP1()
    {
        $session_isadmin = 0;
        $accounts = Account::find()->where(['status' => '1'])->orderBy('sort_rotate')->all();
        $roles = Roles::find()->where(['status' => '1'])->orderBy('id')->all();
        $region = Region::find()->where(['status' => '1'])->orderBy('sort')->all();
        $support_group = SupportGroup::find()->where(['status' => '1', 'region_id' => '0'])->orderBy('sort')->all();
        $support_group_shift = SupportGroupShift::find()->where(['status' => '1'])->orderBy('sort')->all();
        $weeks = SplunkDate::find()->where(['weekday' => '0'])->orderBy('week desc')->all();
        $timezones = Zone::find()->orderBy('zone_name')->all();
        $splunk_date = (new Query())
			->select(["*"])
			->from('splunk_date')
			->where('yearweek=yearweek(curdate()) and weekday=0')
			->orderBy('week desc')
			->one();
            
        $support_group_shift_zone = (new Query())
			->select(['a.id as support_group_shift_id', 'a.region_id as region_id', 'a.support_group_id as support_group_id', 'a.name as shift_name', 'b.name as zone_name', 'b.sort as sort', 'b.id as support_group_shift_zone_id'])
			->from('support_group_shift a, support_group_shift_zone b')
			->where('a.region_id = b.region_id and a.support_group_id = b.support_group_id and a.id=b.support_group_shift_id')
			->orderBy('a.support_group_id, a.region_id, a.id, b.sort')
			->all();
        
        $data = $this->getTotalShift();
            
        return $this->render('p1',['session_isadmin' => $session_isadmin, 'accounts' => $accounts, 'roles' => $roles, 'region' => $region, 'support_group' => $support_group, 'splunk_date' => $splunk_date, 'weeks' => $weeks,
            'timezones' => $timezones, 'support_group_shift' => $support_group_shift, 'support_group_shift_zone' => $support_group_shift_zone, 'total_shifts' => $data["total_shifts"]]);
    }
    
    
    
    public function actionRetrieveShift()
    {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
			
            //$roles = $post['roles'];
            $roles = 1; // Engineer
			$region_id = $post['region'];
			$support_group_id = $post['support_group'];
			
			$result = SupportGroupShift::find()->where(['region_id' => $region_id, 'support_group_id' => $support_group_id, 'status' => $roles])->orderBy('sort')->all();
			$model = array_map(function ($items) {
					return SupportGroupShift::flatForm($items);
					}, $result);
					
            $results["ok"] = "success";
            $results["model"] = $model;
            return json_encode($results);
		}
	}
    
    public function actionRotateAssign()
    {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
			
            $account_id = $post['engr'];
            $action = $post['action'];
            
			$account = Account::findByID($account_id);
            if ($account) {
                $rotation = new Rotation();
                $rotation->case_type = 1;
                $rotation->mode = $action;
                $rotation->support_id = $account_id;
                $rotation->count = 1;
                $rotation->status = 1;
                $rotation->day_num = new Expression('day(curdate())');
                $rotation->day_char = date("D");
                $rotation->week_num = new Expression('week(curdate())');
                $rotation->month_num = new Expression('month(curdate())');
                $rotation->simple_date_at = new Expression('curdate()');
                $rotation->engaged_at = new Expression('now()');
                $rotation->created_at = new Expression('unix_timestamp(now())');
                
                if($rotation->save()){
                    
                    $sum_answered = (new Query())
                    ->select(["sum(count) as sum_answered"])
                    ->from("rotation")
                    ->where("support_id=".$account_id." and week_num=week(curdate()) and mode=1 and deleted_at is NULL")
                    ->one();
                    
                    $sum_missed = (new Query())
                    ->select(["sum(count) as sum_missed"])
                    ->from("rotation")
                    ->where("support_id=".$account_id." and week_num=week(curdate()) and mode=2 and deleted_at is NULL")
                    ->one();
                    
                    $results["ok"] = "success";
                    $results["sum_answered"] = $sum_answered;
                    $results["sum_missed"] = $sum_missed;
                    $results["day_abr"] = date("D");
                    return json_encode($results);
                    //return "ok|$sum_answered|$sum_missed|";
                }
            }
		}
	}
    
    
    public function actionUpdate()
    {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
			
            $account_id = $post['engr'];
            $mode = $post['mode'];
            $comment = $post['comment'];
            $flag = $post['flag'];
            
            $action = 4;
            if($mode == "off")
                $action = 5;
                
            $status = 1;
            if($action == 5)
                $status = 0;
            
			$account = Account::findByID($account_id);
            if ($account) {
                
                $account->status_p1 = $status;
                $account->support_message = $comment;
                
                if($account->save()){
                    $rotation = new Rotation();
                    $rotation->case_type = 1;
                    $rotation->mode = $action;
                    $rotation->support_id = $account_id;
                    $rotation->comment = $comment;
                    $rotation->count = 0;
                    $rotation->status = $status;
                    $rotation->day_num = new Expression('day(curdate())');
                    $rotation->day_char = date("D");
                    $rotation->week_num = new Expression('week(curdate())');
                    $rotation->month_num = new Expression('month(curdate())');
                    $rotation->simple_date_at = new Expression('curdate()');
                    $rotation->engaged_at = new Expression('now()');
                    $rotation->created_at = new Expression('unix_timestamp(now())');
                    
                    if($rotation->save()){
                        
                        $results["ok"] = "success";
                        return json_encode($results);
                    }
                }
            }
		}
	}
    
    
    public function actionAddP1Shift()
    {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
			
            $email = $post['email'];
            $name = $post['name'];
            $phone = $post['phone'];
            $slack_url = $post['slack_url'];
            $roles_id = $post['roles'];
            $timezone_id = $post['timezone'];
			$region_id = $post['region'];
			$support_group_id = $post['support_group'];
            $support_group_shift_id = $post['support_group_shift'];
            
            if($slack_url != "")
                $slack_url = "https://splunk.slack.com/app_redirect?channel=".$slack_url;
			
			$account = Account::findByEmail($email);
            if (!$account) {
                $account = new Account();
                $account->email = $email;
                $account->full_name = $name;
                $account->phone = $phone;
                $account->slack_url = $slack_url;
                $account->timezone = $timezone_id;
                
                $account->roles_id = $roles_id;
                $account->region_id = $region_id;
                if($roles_id == 2){
                    $account->support_group_str = $support_group_id; // will modify later
                } else {
                    $account->support_group_id = $support_group_id;
                    $account->support_group_shift_id = $support_group_shift_id;
                }
                
                $account->save();
                
                return "ok|";
            } else {
                return "email address already exist";
            }
		}
	}
    
    public function getTotalShift()
    {
        $accounts = Account::find()->where(['status' => '1'])->orderBy('sort_rotate')->all();
        $total_shifts = [];
        
        foreach ($accounts as $acct) {
            
            $account_id = $acct->id;
            
            $sum_answered = (new Query())
            ->select(["sum(count) as sum_answered, month(curdate()) as mon"])
            ->from("rotation")
            ->where("support_id=".$account_id." and month_num=month(curdate()) and mode=1 and deleted_at is NULL")
            ->one();
            
            $sum_missed = (new Query())
            ->select(["sum(count) as sum_missed, month(curdate()) as mon"])
            ->from("rotation")
            ->where("support_id=".$account_id." and month_num=month(curdate()) and mode=2 and deleted_at is NULL")
            ->one();
            
             $day_answered = (new Query())
            ->select(["day_num", "day_char"])
            ->from("rotation")
            ->where("support_id=".$account_id." and week_num=week(curdate()) and mode=1 and deleted_at is NULL")
            ->groupby("day_num,day_char")
            ->all();
            
            $day_answered_str = "";
            foreach($day_answered as  $key => $val){
                $day_answered_str .= $val["day_char"].", ";
            }
            if(substr($day_answered_str,strlen($day_answered_str)-2,2) == ", ")
                $day_answered_str = substr($day_answered_str,0,strlen($day_answered_str)-2);
            
            /* Missed */
            
             $day_missed = (new Query())
            ->select(["day_num", "day_char"])
            ->from("rotation")
            ->where("support_id=".$account_id." and week_num=week(curdate()) and mode=2 and deleted_at is NULL")
            ->groupby("day_num,day_char")
            ->all();
            
            $day_missed_str = "";
            foreach($day_missed as  $key => $val){
                $day_missed_str .= $val["day_char"].", ";
            }
            if(substr($day_missed_str,strlen($day_missed_str)-2,2) == ", ")
                $day_missed_str = substr($day_missed_str,0,strlen($day_missed_str)-2);
                
            //if($day_missed_str != "")
            //    $day_missed_str = "(". $day_missed_str.")";
            
            
            $total_shifts[$account_id] = [
                'support_id' => $account_id,
                'mon' => $sum_answered["mon"],
                'total_answered' => $sum_answered["sum_answered"],
                'total_missed' => $sum_missed["sum_missed"],
                'days_answered' => $day_answered_str,
                'days_missed' => $day_missed_str
            ];
        }
        
        return ['total_shifts' => $total_shifts];
    }
    
    
    public function actionRetrieveTables()
    {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
			
            $status = $post['status'];
			
			$tables = (new Query())
			->select(['concat(a.tab_name, lower(b.short_name), c.id) as shift_table'])
			->from('support_group a, region b, support_group_shift c')
			->where('c.support_group_id=a.id and c.region_id=b.id and c.status=1')
			->orderBy('a.tab_name, b.short_name, c.id')
			->all();
					
            $results["ok"] = "success";
            $results["tables"] = $tables;
            return json_encode($results);
		}
	}
    
    
    public function getLibraries()
    {
        /*
		$goals = Goal::find()->where(['enable_library' => true])->andWhere('deleted_at is null')->all();
        $campaigns = [];
		$libraries = [];
		$sublibraries = [];
        foreach ($goals as $goal) {
			
			$tips = Tip::find()->where(['goal_id' => $goal->id])->andWhere('deleted_at is null')->all();
			
			if($goal->supergoal_id == NULL){
				$libraries[$goal->title] = [
					'title' => $goal->title,
					'description' => $goal->info,
					'id' => $goal->id
					];
			} else {
				$sublibraries[$goal->supergoal_id][] = $goal->title.":".$goal->id;
			}
			
			$owner = $goal->owner;
			if ($owner) $owner = [
				'name' => $owner->username,
				'title' => $owner->description,
				'img' => $owner->profile_image
			];
			
			if ($tips) {
				$campaigns[$goal->title] = [
					'title' => $goal->title,
					'description' => $goal->info,
					'owner' => $owner,
					'tips' => $tips
				];
			}
			
        }
		
		return ['campaigns' => $campaigns, 'libraries' => $libraries, 'sublibraries' => $sublibraries];
        */
	}
	
    
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function beforeAction($action) 
	{ 
		$this->enableCsrfValidation = false; 
		return parent::beforeAction($action); 
	}
}
