<?php

$helpers=[
	'js',
	'css',
	'custom_js',
	'custom_css',
	'no_img',
	'no_avatar',
	'active',
	'cn',
	'model',
	'nf',
	'die_log',
	'fDate',
	'dDate',
	'upload_media',
	'update_media',
	'delete_media',
	'media_url',
	'months',
	'no_info',
	'active_badge',
	'str_code',
	'title_case',
	'infos',
	'validate_ajax',
	'auth_user',
	'local_tz',
	'utc_to_ltz',
	'gen_api_key',
	'hash_ids',
	'res_msg',
	'time_dropwon_data',
	'act_log',
	'upload_aws_media',
	'delete_aws_media',
	'aws_media_url',
	'named_aws_media',
	'download_aws_media',
	'update_aws_media',
	'tmp_aws_media',
	'flag_url',
	'lt_to_utc',
];

$helper_exists=FALSE;

foreach($helpers as $helper){

	$helper_exists=function_exists($helper);
	if($helper_exists) break;

}

if($helper_exists) die("Defined helper function {$helper} already exists.");
else{

	function res_msg(String $msg, Int $code=200, Array $data=NULL){

		return response(['msg'=>$msg, 'data'=>$data], $code);
	}

	function hash_ids ($value, $encode = TRUE) {
		$hash_ids=new Hashids\Hashids('hashids_for_passing_url_id', 32);
		if ($encode) {
			return $hash_ids->encode($value);
		} else {
			return $hash_ids->decode($value);
		}
	}

	function js($uri, $base="cdns/node_modules"){

		$path=asset($base);
		//$path="//unpkg.com";

		if(is_string($uri)){
			return "<script src='{$path}/{$uri}'></script>";
		}elseif(is_array($uri)){

			$html='';

			foreach($uri as $value){
				$html.="<script src='{$path}/{$value}'></script>";
			}

			return $html;
		}

	}

	function css($uri, $base="cdns/node_modules"){

		$path=asset($base);
		//$path="//unpkg.com";

		if(is_string($uri)){
			return "<link rel='stylesheet' href='{$path}/{$uri}'>";
		}elseif(is_array($uri)){

			$html='';

			foreach($uri as $value){
				$html.="<link rel='stylesheet' href='{$path}/{$value}'>";
			}

			return $html;
		}

	}

	function custom_js($uri){

		$base=asset('cdns/custom');

		if(is_string($uri)){

			return "<script src='{$base}/{$uri}'></script>";

		}elseif(is_array($uri)){

			$html='';

			foreach($uri as $value){
				$html.="<script src='{$base}/{$value}'></script>";
			}

			return $html;
		}

	}

	function custom_css($uri){

		$base=asset('cdns/custom/css');

		if(is_string($uri)){
			return "<link rel='stylesheet' href='{$base}/{$uri}'>";
		}elseif(is_array($uri)){

			$html='';

			foreach($uri as $value){
				$html.="<link rel='stylesheet' href='{$base}/{$value}'>";
			}

			return $html;
		}

	}

	function no_img($uri='img/no_img.jpg'){
		return asset($uri);
	}

	function no_avatar($uri='img/no_avatar.jpg'){
		return asset($uri);
	}

	function active($url, $active_class="active"){

		$current_url=url()->current();

		if(is_string($url) && $current_url==$url){

			return $active_class;

		}elseif(is_array($url) && in_array($current_url, $url)){

			return $active_class;

		}

	}

	function cn($object, $string, $if_false="N/A"){

	    $properties=explode('.', $string);

	    foreach($properties as $property){

	        if(empty($object->$property)) return $if_false;
	        else{
	            $object=$object->$property;
	        }

	    }

	    if(empty($object)) return $if_false;
	    return $object;

	}

	function model($name){

		return "\\App\\Models\\{$name}";

	}

	function nf($value, $decimal=2){
	    if(empty($value)) $value=0.00;
	    return number_format($value, $decimal);
	}

	function die_log($value){
		die(\Log::info($value));
	}

	function fDate($date, $format='d M Y'){
		if(empty($date)) return '';
		return \Carbon\Carbon::parse($date)->format($format);
	}

	function dDate($date=NULL, $format='d M Y', $default='N/A'){

		if(empty($date)) return $default;
		return date($format, strtotime($date));

	}

	function upload_media(\Illuminate\Http\UploadedFile $file, $args=[]){

		$attr=[
			'model'=>NULL,
			'model_id'=>NULL
		];

		$attr=array_merge($attr, $args);
		$media=\App\Models\Media::create($attr);
		$media->original_name=$file->getClientOriginalName();
		$media->extension=$file->getClientOriginalExtension();
		$media->type=$file->getMimeType();
		$media->size=$file->getSize();

		do{
	    	$filename=uniqid($media->id).'.'.$media->extension;
		}while(\Storage::disk('media')->exists($filename));

		$media->file=$filename;
		$media->save();

		$file->storeAs(NULL, $filename, 'media');

		//\Storage::disk('media')->put($media->file, $file->getRealPath());

		return $media;

	}

	function update_media(
		$id_or_file,
		\Illuminate\Http\UploadedFile $new_file
	){

		$media=NULL;

		if(is_int($id_or_file)){

			$media=\App\Models\Media::find($id_or_file);

		}elseif(is_string($id_or_file)){

			$media=\App\Models\Media::Where('file', $id_or_file)->first();

		}

		if(empty($media)) return FALSE;

		$old_file=$media->file;

		$media->original_name=$new_file->getClientOriginalName();
		$media->extension=$new_file->getClientOriginalExtension();
		$media->type=$new_file->getMimeType();
		$media->size=$new_file->getSize();

		do{
	    	$filename=uniqid($media->id).'.'.$media->extension;
		}while(\Storage::disk('media')->exists($filename));

		$media->file=$filename;
		$media->update();

		$new_file->storeAs(NULL, $filename, 'media');

		if(\Storage::disk('media')->exists($old_file)){

			\Storage::disk('media')->delete($old_file);

		}

		return $media;

	}

	function delete_media($id_or_file){

		$media=NULL;

		if(is_int($id_or_file)){

			$media=\App\Models\Media::find($id_or_file);

		}elseif(is_string($id_or_file)){

			$media=\App\Models\Media::Where('file', $id_or_file)->first();

		}

		if(empty($media)) return FALSE;

		if(\Storage::disk('media')->exists($media->file)){

			\Storage::disk('media')->delete($media->file);

		}

		if($media->delete()) return TRUE;
		return FALSE;

	}

	function media_url($id_or_file){

		if(is_int($id_or_file)){

			$media=\App\Models\Media::find($id_or_file);
			if(empty($media)) return FALSE;
			return asset("media/{$media->file}");

		}elseif(is_string($id_or_file)){

			$file_exists=\Storage::disk('media')->exists($id_or_file);
			if($file_exists) return asset("media/{$id_or_file}");

		}

		return FALSE;

	}

	function months($month_format='M'){

	    $months=[];

	    for($i=1; $i<=12; $i++){
	        $months[$i] = date($month_format, mktime(0, 0, 0, $i, 1));
	    }

	    return $months;

	}

	function no_info($msg="No Information Available."){

		return "<strong class='d-block text-center m-2'><i class='fa fa-exclamation-circle fa-lg text-warning mr-1' aria-hidden='true'></i>No Information Available.</strong>";

	}

	function active_badge($condition, $if_true='badge-success', $if_false='badge-danger'){

		if($condition){
			$color=$if_true;
			$text='Yes';
		}else{
			$color=$if_false;
			$text='No';
		}

		return "<span class='badge {$color}'>{$text}</span>";

	}

	function str_code(string $str){

		$str=str_replace(['-', ',', '.', ' '], '_', $str);
		$str=str_replace(['__'], '_', $str);

		return strtolower($str);

	}

	function str_title($str){
		return ucwords(str_replace(['_', '-', ','], ' ', $str));
	}

	function infos($key, $default=NULL){

		$info=\App\Models\Info::where('key', $key)->first();

		if($info) return $info->value;
		return $default;

	}

	function validate_ajax(array $rules, array $msg=[]){

        $validator=\Validator::make(request()->all(), $rules, $msg);

        if($validator->fails()){

            $errors=$validator->errors()->all();

            $result=(Object) [
            	'error'=>TRUE,
            	'msg'=>response(['msg'=>$errors[0]], 422)
            ];

        }else{

	        $result=(Object) [
	        	'error'=>FALSE,
	        	'msg'=>NULL
	        ];

        }

        return $result;

	}

	function auth_user($guard=NULL){

		return Illuminate\Support\Facades\Auth::user();

	}

	function local_tz(\App\Models\User $user=NULL, $default='UTC'){

		if(empty($user)) $user=\Auth::user();

		if($user && $user->last_timezone){
			return $user->last_timezone;
		}

		return $default;

	}

	function utc_to_ltz($time_str, $format='d M Y g:i A', $tz=NULL){

		if(empty($tz)) $tz=local_tz();

		return \Carbon\Carbon::parse(
			$time_str
		)->setTimezone($tz)->format($format);

	}

	function lt_to_utc($time_str, $tz='Asia/Dhaka'){

		return \Carbon\Carbon::parse(
			$time_str, $tz
		)->setTimezone('UTC');

	}

	function gen_api_key(){

	    return implode(
	    	'-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6)
	    );

	}

	function get_status($args){

		$qb=\App\Models\Status::where('active', 1);

		if(is_string($args)) $qb->where('code', $args);
		elseif(is_int($args)) $qb->where('id', $args);
		else return new \App\Models\Status;

		return $qb->first();

	}

	function get_statuses($group_code){

		return \App\Models\Status::where([
			'active'=>1
		])->whereHas('group', function($q)use($group_code){
			$q->where('code', $group_code);
		})->orderBy('serial')->get();


	}

    function name_initials($name){
        $nameParts=explode(' ', trim($name));
        $firstName=array_shift($nameParts);
        $lastName=array_pop($nameParts);
        return strtoupper(mb_substr($firstName, 0, 1) . mb_substr($lastName, 0, 1));
    }

	function time_dropdown_data(){

		$intervals=95;
		$start_time="05:45";
		$data=[];

		$c=new \Carbon\Carbon;

		for($i=0; $i<=$intervals; $i++){

			array_push($data, (Object) [
				'id'=>$c->parse($start_time)->addMinutes(15)->format('H:i:s'),
				'label'=>$c->parse($start_time)->addMinutes(15)->format('g:i A')
			]);

			$start_time=$c->parse($start_time)->addMinutes(15)->format('H:i:s');

		}

		return $data;

	}

	function act_log(Array $args, Bool $return_data=FALSE){

		$log_code=\App\Models\Status::where([
			'active'=>1,
			'code'=>empty($args['code'])?NULL:$args['code']
		])->first();

		$data=[
			'model'=>empty($args['model'])?NULL:get_class($args['model']),
			'model_id'=>empty($args['model'])?NULL:$args['model']->id,
			'log_type_id'=>$log_code?$log_code->id:NULL,
			'action'=>empty($args['action'])? 'General' : $args['action'],
			'data'=>empty($args['data'])? NULL : json_encode($args['data']),
			'subject'=>empty($args['subject'])?'Not Specified':$args['subject'],
			'description'=>empty($args['desc'])?NULL:$args['desc'],
			'creator_id'=>empty($args['user'])?NULL:$args['user']->id
		];

		if(!$return_data){

			return \App\Models\ActivityLog::create($data);

		}else return $data;

	}

	function upload_aws_media(
		\Illuminate\Http\UploadedFile $file,
		$args=[],
		string $folder_path=NULL
	){

		if(empty($folder_path)) $folder_path='aws_media';
		else $folder_path=trim($folder_path, '/');

		$document_type_id = NULL;

		if(isset($args['document_type'])) {

			if ($args['document_type'] instanceof \App\Models\DocumentType) {
				$document_type_id = $args['document_type']->id;
			} else if (is_int($args['document_type'])) {
				$document_type_id = $args['document_type'];
			}

		}

		$attr=[
			'model'=>NULL,
			'model_id'=>NULL,
			'document_type_id'=>$document_type_id,
			'folder_path'=>$folder_path,
		];

		if($args) $attr=array_merge($attr, $args);

		$aws_media=\App\Models\AwsMedia::create($attr);
		$aws_media->original_name=$file->getClientOriginalName();
		$aws_media->extension=$file->getClientOriginalExtension();
		$aws_media->type=$file->getMimeType();
		$aws_media->size=$file->getSize();

		do{
				$filename=uniqid($aws_media->id).'.'.$aws_media->extension;
		}while(\Storage::disk('s3')->exists($folder_path.'/'.$filename));

		$aws_media->file=$filename;
		$aws_media->save();

		$file->storeAs($folder_path, $filename, 's3');

		//\Storage::disk('media')->put($media->file, $file->getRealPath());

		return $aws_media;

	}

	function delete_aws_media($id_or_file){

		$aws_media=NULL;

		if(is_int($id_or_file)){

			$aws_media=\App\Models\AwsMedia::find($id_or_file);

		}elseif(is_string($id_or_file)){

			$aws_media=\App\Models\AwsMedia::Where('file', $id_or_file)->first();

		}

		if(empty($aws_media)) return FALSE;

		if(empty($aws_media->folder_path)) $folder_path='aws_media';
		else $folder_path=$aws_media->folder_path;

		if(\Storage::disk('s3')->exists($folder_path.'/'.$aws_media->file)){

			\Storage::disk('s3')->delete($folder_path.'/'.$aws_media->file);

		}

		if($aws_media->delete()) return TRUE;
		return FALSE;

	}

/* 	function aws_media_url($id_or_file){

		$aws_media=NULL;

		if(is_int($id_or_file)){

			$aws_media=\App\Models\AwsMedia::find($id_or_file);

		}elseif(is_string($id_or_file)){

			$aws_media=\App\Models\AwsMedia::Where('file', $id_or_file)->first();

		}

		if(empty($aws_media)) return FALSE;

		if(empty($aws_media->folder_path)) $folder_path='aws_media';
		else $folder_path=$aws_media->folder_path;

		return \Storage::disk('s3')->url($folder_path.'/'.$aws_media->file);

	} */

	function named_aws_media(\App\Models\AwsMedia $aws_media, $suffix=NULL){

		$new_filename='download_'.uniqid();
		$lead=$aws_media->lead;

		if($lead){
			$new_filename=str_slug("{$lead->given_name}_{$lead->family_name}_{$aws_media->document_type}", "_");
		}

		if($suffix){

			$new_filename.='_'.str_slug($suffix, '_').'.'.$aws_media->extension;

		}else $new_filename.='.'.$aws_media->extension;

		return $new_filename;

	}

	function download_aws_media($aws_media_id, string $suffix=NULL){

		$aws_media=\App\Models\AwsMedia::find($aws_media_id);

		if(empty($aws_media)) return abort(404);

		$file_exists=\Storage::disk('s3')->exists($aws_media->folder_path.'/'.$aws_media->file);

		if(!$file_exists) return abort(404);

		/*$new_filename='download_'.uniqid();
		$lead=$aws_media->lead;

		if($lead){

			$new_filename=str_slug("{$lead->given_name}_{$lead->family_name}_{$aws_media->document_type}", "_");

		}

		if($suffix){

			$new_filename.='_'.str_slug($suffix, '_').'.'.$aws_media->extension;

		}else $new_filename.='.'.$aws_media->extension;*/

		$new_filename=named_aws_media($aws_media, $suffix);

			$headers=[];

			return \Storage::disk('s3')->download(
					$aws_media->folder_path.'/'.$aws_media->file,
					$new_filename,
					$headers
			);

	}

	function update_aws_media(
		$aws_media_id,
		\Illuminate\Http\UploadedFile $new_file
	){

		$aws_media=\App\Models\AwsMedia::find($aws_media_id);

		if(empty($aws_media)) return FALSE;

		if(empty($aws_media->folder_path)) $folder_path='aws_media';
		else $folder_path=$aws_media->folder_path;

		$old_file=$folder_path.'/'.$aws_media->file;

		$aws_media->original_name=$new_file->getClientOriginalName();
		$aws_media->extension=$new_file->getClientOriginalExtension();
		$aws_media->type=$new_file->getMimeType();
		$aws_media->size=$new_file->getSize();

		do{
				$filename=uniqid($aws_media->id).'.'.$aws_media->extension;
		}while(\Storage::disk('s3')->exists($folder_path.'/'.$filename));

		$aws_media->file=$filename;
		$aws_media->save();

		$new_file->storeAs($folder_path, $filename, 's3');

		if(\Storage::disk('s3')->exists($old_file)){

			\Storage::disk('s3')->delete($old_file);

		}

		return $aws_media;

	}

	function tmp_aws_media($aws_media){

		if(is_int($aws_media)){
			$aws_media=\App\Models\AwsMedia::find($aws_media);
		}

		if(!$aws_media instanceof \App\Models\AwsMedia){
			return NULL;
		}

		$file_exists = \Storage::disk('tmp_aws_media')->exists($aws_media->file);

		if(empty($file_exists)){
			$content = \Storage::disk('s3')->get($aws_media->folder_path.'/'.$aws_media->file);
			\Storage::disk('tmp_aws_media')->put($aws_media->file, $content);
		}

		$url = \Storage::disk('tmp_aws_media')->url(
			$aws_media->file
		);

		return $url;

	}

	function aws_media_filename($aws_media){

		if(is_int($aws_media)){
			$aws_media = \App\Models\AwsMedia::find($aws_media);
		}

		if(!$aws_media instanceof \App\Models\AwsMedia){
			return NULL;
		}

		return $aws_media->original_name;

	}

	function flag_url($code, $size='1x1'){
		//alt size 4x3
		return asset("static/flags/{$size}/".strtolower($code).".svg");
	}

	function get_document_type($args){

		if(is_string($args)){
			return model('DocumentType')::where('name', $args)->first();
		} elseif(is_int($args)) {
			return model('DocumentType')::where('id', $args)->first();
		} else {
			return new \App\Models\Status;
		}

	}

	function get_excel_date_to_real_date($excel_date = NULL){
		if ($excel_date) {
			/* Please use this formula to change from Excel date to Unix date, then you can use "gmdate" to get the real date in PHP */

			$unix_date = ($excel_date - 25569) * 86400; // 86400 = Seconds in a day
			$excel_date = 25569 + ($unix_date / 86400); // 25569 = Days between 1970/01/01 and 1900/01/01
			$unix_date = ($excel_date - 25569) * 86400;

			return gmdate("Y-m-d", $unix_date);

		} else {
			return NULL;
		}

	}

	function get_excel_time_to_real_time($excel_time = NULL){
		if ($excel_time) {
			$time = $excel_time * 86400; // 86400 = Seconds in a day
			return date('H:i:s', $time);

		} else {
			return NULL;
		}

	}

	function getIPAddress() {
		//whether ip is from the share internet
		if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from the proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from the remote address
		else{
			$ip = $_SERVER['REMOTE_ADDR'];
		 }
		 return $ip;
	}

	function getDeviceTypeId() {
		// Check if the "mobile" word exists in User-Agent
		$isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));

		// Check if the "tablet" word exists in User-Agent
		$isTab = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "tablet"));

		if($isMob){
			if($isTab){
				return 300; //Using Tablet Device...
			}else{
				return 200; //Using Mobile Device...
			}
		}else{
			return 100; //Using Desktop...
		}
	}

	function getCurrentLocalTime() {
		$current_utc_time= gmdate("h:i:s A");
		$current_local_time = utc_to_ltz($current_utc_time, 'g:i A');
		return $current_local_time;
	}

	function laravel_paginate_array($total, $per_page, $current_page=NULL, $array_data=NULL){

		if(empty($current_page)) $current_page=1;

		$current_url=url()->current();
		$query_string=request()->getQueryString();
		if($query_string){

			$query_string=str_replace([
				// "&page={$current_page}&",
				"&page={$current_page}",
				"page={$current_page}&",
				"page={$current_page}"
			], '', $query_string);

		}

		if($total > 0) $last_page=ceil($total / $per_page);
		else $last_page=$current_page;

		if($current_page==$last_page) $next_page=NULL;
		else $next_page=$current_page+1;

		if($next_page && $query_string){
			$next_page_url="{$current_url}?{$query_string}&page={$next_page}";
		}elseif($next_page){
			$next_page_url="{$current_url}?page={$next_page}";
		}else $next_page_url=NULL;

		if($current_page > 1 && $query_string){
			$prev_page_url="{$current_url}?{$query_string}&page=".($current_page-1);
		}if($current_page > 1){
			$prev_page_url="{$current_url}?page=".($current_page-1);
		}else $prev_page_url=NULL;

		if($current_page==$last_page){

			$from=($per_page*($current_page-1))+1;
			$to=($per_page*($current_page-1))+($total%$per_page);

		}elseif($current_page > 1){

			$from=($per_page*($current_page-1))+1;
			$to=($per_page*($current_page-1))+$per_page;

		}else{

			$from=1;
			$to=$per_page;

		}

		if($query_string){
			$first_page_url="{$current_url}?{$query_string}&page=1";
			$last_page_url="{$current_url}?{$query_string}&page={$last_page}";
		}else{
			$first_page_url="{$current_url}?page=1";
			$last_page_url="{$current_url}?page={$last_page}";
		}

		return [
			'total'=>$total,
			'per_page'=>$per_page,
			'current_page'=>$current_page,
			'last_page'=>$last_page,
			'first_page_url'=>$first_page_url,
			'last_page_url'=>$last_page_url,
			'next_page_url'=>$next_page_url,
			'prev_page_url'=>$prev_page_url,
			'path'=>$current_url,
			'from'=>$from,
			'to'=>$to,
			'data'=>$array_data
		];

	}

	function getCompanyFullAddress ($company) {
		$full_address = '';
		if ($company) {
			if ($company->head_office && $company->head_office->address) {
				if ($company->head_office->address->address) {
					$full_address =  $full_address . $company->head_office->address->address. ', ';
				}

				if ($company->head_office->address->area) {
					$full_address =  $full_address . $company->head_office->address->area->name. ', ';
				}

				if ($company->head_office->address->district) {
					$full_address =  $full_address . $company->head_office->address->district->name. ', ';
				}

				if ($company->head_office->address->state) {
					$full_address =  $full_address . $company->head_office->address->state->name. '.';
				}

			}
		}

		return $full_address;
	}

}
//End of function existance check
