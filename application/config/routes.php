<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['userTypeCreate'] = "UserType/createUserType"; //controller/methodname
$route['userLogin'] = "Login/loginAuth"; //controller/method name

//User Manager
$route['userCreate'] = "UsersMst/createUser"; //controller/methodname

//***************** Start Routes For API ********************
$route['signup_api'] = 'api/v1/home/signup';
$route['login_api'] = 'api/v1/home/login';
$route['forgot_password_api'] = 'api/v1/home/forgot_password';
$route['reset_password_form_api'] = 'api/v1/home/reset_password_form';
$route['reset_password_api'] = 'api/v1/home/reset_password';
$route['logout_api'] = 'api/v1/home/logout';
$route['check_authentication_api'] = 'api/v1/home/check_authentication';
$route['home_api'] = 'api/v1/home/index';
$route['omoverview_api'] = 'api/v1/dashboard/omoverview';
$route['ongoing_upcoming_programs_api'] = 'api/v1/dashboard/ongoing_upcoming_programs';
$route['my_journey_with_om_api'] = 'api/v1/dashboard/my_journey_with_om';
$route['queries_questions_list_api'] = 'api/v1/contactus/queries_questions_list';
$route['queries_questions_api'] = 'api/v1/contactus/queries_questions';
$route['share_stories_list_api'] = 'api/v1/contactus/share_stories_list';
$route['post_categories_list_api'] = 'api/v1/contactus/post_categories_list';
$route['add_share_stories_api'] = 'api/v1/contactus/add_share_stories';
$route['get_share_stories_api'] = 'api/v1/contactus/get_share_stories';
$route['edit_share_stories_api'] = 'api/v1/contactus/edit_share_stories';
$route['delete_share_stories_api'] = 'api/v1/contactus/delete_share_stories';
$route['download_share_stories_api'] = 'api/v1/contactus/download_share_stories';
$route['contact_us_api'] = 'api/v1/contactus/contact_us';
$route['profile_details_api'] = 'api/v1/home/profile_details';
$route['change_profile_api'] = 'api/v1/home/change_profile';
$route['change_password_api'] = 'api/v1/home/change_password';
$route['batch_list_api'] = 'api/v1/batch/batch_list';
$route['add_batch_form_api'] = 'api/v1/batch/add_batch_form';
$route['region_by_state_api'] = 'api/v1/batch/region_by_state';
$route['center_by_region_api'] = 'api/v1/batch/center_by_region';
$route['add_batch_api'] = 'api/v1/batch/add_batch';
$route['edit_batch_form_api'] = 'api/v1/batch/edit_batch_form';
$route['edit_batch_api'] = 'api/v1/batch/edit_batch';
$route['delete_batch_api'] = 'api/v1/batch/delete_batch';
$route['user_list_api'] = 'api/v1/user/user_list';
$route['add_user_form_api'] = 'api/v1/user/add_user_form';
$route['district_by_state_api'] = 'api/v1/user/district_by_state';
$route['city_by_district_api'] = 'api/v1/user/city_by_district';
$route['add_user_api'] = 'api/v1/user/add_user';
$route['edit_user_form_api'] = 'api/v1/user/edit_user_form';
$route['edit_user_api'] = 'api/v1/user/edit_user';
$route['delete_user_api'] = 'api/v1/user/delete_user';
$route['bulk_user_upload_api'] = 'api/v1/user/bulk_user_upload';
$route['download_list_api'] = 'api/v1/download/download_list';
$route['download_files_api'] = 'api/v1/download/download_files';
$route['fetch_yearly_goals_list_api'] = 'api/v1/yearlygoals/fetch_yearly_goals_list';
$route['add_yearly_goals_program_api'] = 'api/v1/yearlygoals/add_yearly_goals_program';
$route['fetch_data_for_yearly_goals_program_form_list_api'] = 'api/v1/yearlygoals/fetch_data_for_yearly_goals_program_form_list';
$route['save_yearly_goals_program_details_api'] = 'api/v1/yearlygoals/save_yearly_goals_program_details';
$route['program_feedback_form_data_api'] = 'api/v1/review/program_feedback_form_data';
$route['program_name_by_batch_id_api'] = 'api/v1/review/program_name_by_batch_id';
$route['dynamic_field_options_by_related_table_name_api'] = 'api/v1/review/dynamic_field_options_by_related_table_name';
$route['dynamic_field_optionlist_api'] = 'api/v1/review/dynamic_field_optionlist';
$route['program_feedback_review_api'] = 'api/v1/review/program_feedback_review';
$route['personal_reflection_form_data_api'] = 'api/v1/review/personal_reflection_form_data';
$route['personal_reflection_review_api'] = 'api/v1/review/personal_reflection_review';
$route['feedback_for_participants_form_data_api'] = 'api/v1/review/feedback_for_participants_form_data';
$route['total_registered_participants_by_batch_id_api'] = 'api/v1/review/total_registered_participants_by_batch_id';
$route['feedback_for_participants_review_api'] = 'api/v1/review/feedback_for_participants_review';
$route['program_feedback_by_participants_form_data_api'] = 'api/v1/review/program_feedback_by_participants_form_data';
$route['program_feedback_by_participants_review_api'] = 'api/v1/review/program_feedback_by_participants_review';
$route['star_participants_form_data_api'] = 'api/v1/review/star_participants_form_data';
$route['star_participants_review_api'] = 'api/v1/review/star_participants_review';
$route['impact_assessment_form_data_api'] = 'api/v1/review/impact_assessment_form_data';
$route['impact_assessment_review_api'] = 'api/v1/review/impact_assessment_review';
//***************** End Routes For API ********************
