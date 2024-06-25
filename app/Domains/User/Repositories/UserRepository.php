<?php

namespace App\Domains\User\Repositories;

use App\Models\User;
use App\Domains\User\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * CompanyRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table()
    {

                    return DB::select("select users.id , users.username ,users.name ,users.email , users.phone ,roles.id as 'role_id',roles.name as 'role_name'
                                        from users
                                        inner join roles on users.role_id = roles.id ; "
                    );


       
    }

    public function get_branch_managers(){
        $query= "SELECT users.* FROM users 
        inner join roles on roles.id = users.role_id  and roles.name = 'branch manager' ";
         return DB::select($query);
    }
    public function prepare_visitors_data_table($user_role,$filter)
    {
        $user_id =auth()->user()->id;
        $query='';
       if( $user_role == 1 || $user_role == 5){
     
                    $query = "select * from  (select v.id, v.name, v.phone , companies.name as 'company_name', 

                    (select date(created_at) from coupon_requests where customer_id = v.id order by created_at  ASC limit 1) as 'join_date' , 
                    (select date(created_at) from coupon_requests where customer_id = v.id order by created_at  DESC limit 1) as 'last_visit',
                    (select count(id) from coupon_requests where customer_id=  v.id ) as 'coupons'
                    from visitors v
                    left join companies on v.company_id = companies.id ) As t ";

                 
                    

        }elseif($user_role == 2){
            $query = "select * from  (select v.id,v.name, v.phone , companies.name as 'company_name', 

            (select date(created_at) from coupon_requests where customer_id = v.id order by created_at  ASC limit 1) as 'join_date' , 
            (select date(created_at) from coupon_requests where customer_id = v.id order by created_at  DESC limit 1) as 'last_visit',
            (select count(id) from coupon_requests where customer_id=  v.id ) as 'coupons'
            from visitors v
            left join companies on companies.company_representative_id =".$user_id." ) As t ";
            
        }
        if($filter && ($filter['from'] != "" || $filter['to'] != "")){
            $query .=" WHERE ";
            if($filter['from'] != ""){
                $query .=" date(t.join_date) >= '".$filter['from']."'";;
            }

            if($filter['from'] != "" && $filter['to'] != ""){
                $query .=" and ";
            }

            if($filter['to'] != ""){
                $query .=" date(t.last_visit) <= '".$filter['to']."'";
            }
        }
        if($query){
            return DB::select($query);
        }else{
            return [];
        }
       
    }
    public function all_visitors()
    {
     
        $query = "select * from  visitors";    
                    
       return DB::select($query);
       
    }


    public function get_role_id_by_name($role)
    {
        return DB::select("SELECT id from roles where name = '$role'")[0];
    }

    public function get_all_users($role)
    {
        $role = $this->get_role_id_by_name($role);
        return DB::select("SELECT * from users where role_id = $role->id");
    }
    public function get_companies() 
    {
        return DB::select("SELECT companies.id,companies.name,companies.coupons_limit,companies.coupons_counter , images.file as logo ,users.email  from companies
                            LEFT JOIN images
                            ON companies.id = images.imageable_id
                                AND images.field = 'logo'
                                AND images.imageable_type LIKE '%\Company'
                                LEFT JOIN users on users.id = companies.company_representative_id  ");
    }
    public function check_limit_alerts($company_id)
    {
        return DB::select("select ratio   from limit_alerts where company_id =".$company_id."  ORDER by id DESC  LIMIT 1");
    }
    public function add_alert($ratio,$company_id)
    {
        $date = date('Y-m-d');
        return DB::insert("insert into limit_alerts (title , ratio , company_id , created_at)values( 'Coupon is ".$ratio."% used.', $ratio , $company_id,'$date')");
    }
    
    public function get_alerts($role_id){
       $user_id =auth()->user()->id;
       if( $role_id && $role_id == 2 ){
        $limit=" SELECT limit_alerts.* , companies.name as 'company_name' from  limit_alerts
                inner join companies on limit_alerts.company_id = companies.id
                and companies.company_representative_id =". $user_id."
                WHERE limit_alerts.id not in (select limit_alerts_id from users_limit_alerts where user_id =". $user_id.")";
       }elseif($role_id && $role_id == 1){
        $limit = "SELECT limit_alerts.* , companies.name as 'company_name' from limit_alerts 
                    inner join companies on limit_alerts.company_id = companies.id
                    WHERE limit_alerts.id not in (select limit_alerts_id from users_limit_alerts where user_id =".$user_id." )";

         $survey = " SELECT surveyalerts.id , surveyalerts.submission_id , submissions.degree,  surveyalerts.created_at , visitors.name from  surveyalerts
                    inner join visitors on  visitors.id = surveyalerts.user_id 
                    inner join submissions on  submissions.id = surveyalerts.submission_id

                    WHERE surveyalerts.id not in (select survey_alerts_id from users_survey_alerts where user_id =".$user_id.")";
                }

       return (object) [
        "limit" => DB::select($limit),
        "survey" =>  DB::select($survey) ,
        ];
    }
    public function alerts_seen($alert_id ,$type){
        $user_id =auth()->user()->id;
        if($type=='limit'){
           DB::insert("insert into users_limit_alerts (user_id , limit_alerts_id )values(".$user_id.",".$alert_id.")");
        }elseif($type=='survey'){
            DB::insert("insert into users_survey_alerts (user_id , survey_alerts_id )values(".$user_id.",".$alert_id.")");
        }

    }
    public static function sendmail_daily(){
        return DB::select("SELECT companies.name , images.file as logo , (select count(id) FROM coupon_requests where company_id = companies.id ) as 'total',  companies.coupons_limit as 'limit' , companies.coupons_counter as 'used' ,
        ROUND(companies.coupons_counter /companies.coupons_limit*100,0) as'relatively' ,
        users.email 
        from companies
        inner JOIN users on users.id = companies.company_representative_id
        LEFT JOIN images
                            ON companies.id = images.imageable_id
                                AND images.field = 'logo'
                                AND images.imageable_type LIKE '%\Company'
                                
           where companies.coupons_limit <> 0 ");
    }   
    
    public function find_visitor($mobile,$email){
        return DB::select("SELECT * from visitors where phone = $mobile OR email = '".$email."'  ");
    }
    public function add_customers($request){
        return DB::table('visitors')->insertGetId(array(
            'name' =>$request->name,
            'phone' =>$request->phone,
            'email' =>$request->email,
            'gender' =>$request->gender,
            'created_at' => date('Y-m-d'),
        ));
    }
    

    public function import_customers($request){
        $imported_ids = array();
        try{
            $file =  $request->file('file');
            $sheets = (new FastExcel)->importSheets($file);
            $rows =  $sheets[0];
            if(count($rows) > 10000){
                return response()->json(['message'=> __('The maximum allowed is 10,000 records'), 'success' => false]); 
            }
            foreach ($rows as $row){
                
                $data_sheet = json_decode(json_encode($row),true);
                $fr_num = mb_substr($data_sheet['phone'],0,1);
                if($fr_num != 0){
                    $phone ='0'.$data_sheet['phone'] ;
                }else{
                    $phone = $data_sheet['phone'];
                }
                $data =  DB::select("SELECT * from visitors where phone = '". $phone."' OR email = '".$data_sheet['email']."' ");
                $gender = '';
                if($data_sheet['gender'] == 'male' || $data_sheet['gender'] == 'female'){
                    $gender = $data_sheet['gender'];
                }
                // return var_dump($data);
                if(empty($data)){

                    $id =  DB::table('visitors')->insertGetId(array(
                        'name' =>$data_sheet['name'] ,
                        'phone' =>  $phone,
                        'email' => $data_sheet['email'],
                        'gender' => ($gender!='') ? $gender :'male',
                        'created_at' => date('Y-m-d'),
                    ));
                    if(isset($data_sheet['branch_id']) && $data_sheet['branch_id']!=''){
                        $record = DB::table('visitors_branches')
                            ->select('id')
                            ->where('visitor_id', $id)
                            ->where('branch_id', $data_sheet['branch_id'])
                            ->get();
                            if($record->isEmpty() ){
                            DB::table('visitors_branches')->insertGetId(
                                [
                                'visitor_id' => $id,
                                'branch_id' => $data_sheet['branch_id'],
                                ]
                            );
                            } 
                    }
                    $imported_ids[]=$id;
                }else{
                    DB::table('visitors')
                    ->where('id',$data[0]->id)
                    ->update([
                            'name' =>$data_sheet['name'] ,
                            'phone' =>  $phone,
                            'email' => $data_sheet['email'],
                            'gender' => ($gender!='') ? $gender :'male',
                    ]); 
                    if(isset($data_sheet['branch_id']) && $data_sheet['branch_id']!=''){
                        $record = DB::table('visitors_branches')
                            ->select('id')
                            ->where('visitor_id', $data[0]->id)
                            ->where('branch_id', $data_sheet['branch_id'])
                            ->get();
                            if($record->isEmpty() ){
                            DB::table('visitors_branches')->insertGetId(
                                [
                                'visitor_id' => $data[0]->id,
                                'branch_id' => $data_sheet['branch_id'],
                                ]
                            );
                            } 
                    }
                }
            
            
        
            }
            return response()->json(['message'=> __('file imported successfully'), 'success' => true]); 

        }catch (\Throwable $th) {
            foreach($imported_ids as $id){
                DB::table('visitors')->where('id', $id)->delete();
            }
            return response()->json(['message'=> __('There is an error in the file'), 'success' => false]);   
        }   
    }
    

}
