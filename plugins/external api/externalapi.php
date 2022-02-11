<?php
/**
 * Plugin name: Query API
 * Plugin URI: https://Shubhamrawat.com
 * Description: Get information from external APIs in WordPress
 * Author: Shubham 
 * Author URI: https://Shubhamrawat.com
 * version: 0.1.0
 * License: 
 * text-domain: query-apis
 */

// If this file is access directly, abort!!!
defined( 'ABSPATH' ) or die( 'Unauthorized Access' );

//[myshortcode]
add_shortcode('external_data', 'callback_function_name');
// $ - object
function callback_function_name() {

    $url = 'https://jsonplaceholder.typicode.com/users';
    
    $arguments = array(
        'method' => 'GET'
    );

	$response = wp_remote_get( $url, $arguments );

    //error handling
	if ( is_wp_error( $response ) ) {
		$error_message = $response->get_error_message();
		return "Something went wrong: $error_message";
	} 
	$results = json_decode( wp_remote_retrieve_body( $response ) );
    // var_dump($results);
		

    $html = '';
    $html .= '<h2></h2>';
    $html .= '<table>';
    $html .='<colgroup>
    <col span="2" style="background-color: pink">
  </colgroup>';


    $html .= '<tr>';
    $html .= '<th><b> Rank </th>';
    $html .= '<th><b> Winners </b></th>';
    $html .= '<th><b> Username </b></th>';
    $html .= '<th><b> Email </b></th>';
    $html .= '<th><b> Address </b></th>';
    $html .= '</tr>';

    foreach($results as $result){
        $html .= '<tr>';
        $html .= '<td>' . $result->id . '</td>';
        $html .= '<td>' . $result->name . '</td>';
        $html .= '<td>' . $result->username . '</td>';
        $html .= '<td>' . $result->email . '</td>';
        $html .= '<td>' . $result->address->street . ',' . $result->address->suite . ',' . $result->address->city . ',' . $result->address->cityzipcode . '</td>';
        $html .= '</tr>';

    }
   
    $html .= '</table>';

    return $html;

    
}	



?>
