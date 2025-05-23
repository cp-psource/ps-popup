<?php

/*

Name:        Grundlegende URL

Plugin URI:  https://n3rds.work/piestingtal-source-project/ps-popup/

Description: Einfacher und schneller URL-Abgleich.

Author:      DerN3rd (PSOURCE)

Author URI:  https://n3rds.work

Type:        Rule

Rules:       Auf einer bestimmten URL, Nicht auf einer bestimmten URL

Version:     1.1



NOTE: DON'T RENAME THIS FILE!!

This filename is saved as metadata with each popup that uses these rules.

Renaming the file will DISABLE the rules, which is very bad!

*/



class IncPopupRule_Url extends IncPopupRule {



	/**

	 * Initialize the rule object.

	 *

	 * @since  1.6

	 */

	protected function init() {

		$this->filename = basename( __FILE__ );



		// 'url' rule.

		$this->add_rule(

			'url',

			__( 'Auf einer bestimmten URL', 'popover' ),

			__( 'Zeigt das PopUp an, wenn sich der Benutzer unter einer bestimmten URL befindet.', 'popover' ),

			'no_url',

			20

		);



		// 'no_url' rule.

		$this->add_rule(

			'no_url',

			__( 'Nicht auf einer bestimmten URL', 'popover' ),

			__( 'Zeigt das PopUp an, wenn sich der Benutzer nicht auf einer bestimmten URL befindet.', 'popover' ),

			'url',

			20

		);

	}





	/*=========================*\

	=============================

	==                         ==

	==           URL           ==

	==                         ==

	=============================

	\*=========================*/





	/**

	 * Apply the rule-logic to the specified popup

	 *

	 * @since  1.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 * @return bool Decission to display popup or not.

	 */

	protected function apply_url( $data ) {

		$data = $this->sanitize_values( $data );

		$url = $this->current_url();



		return $this->check_url( $url, $data );

	}



	/**

	 * Output the Admin-Form for the active rule.

	 *

	 * @since  1.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 */

	protected function form_url( $data ) {

		$data = $this->sanitize_values( $data );

		$urls = implode( "\n", $data );

		?>

		<label for="po-rule-data-url">

			<?php _e( 'Auf diesen URLs anzeigen (eine pro Zeile):', 'popover' ); ?>

		</label>

		<textarea name="po_rule_data[url]" id="po-rule-data-url" class="block"><?php

			echo esc_html( $urls );

		?></textarea>

		<div><em>

		<?php

		_e( 'URLs sollten nicht "http://" oder "https://" enthalten.', 'popover' );

		?>

		</em></div>

		<?php

	}



	/**

	 * Update and return the $settings array to save the form values.

	 *

	 * @since  1.6

	 * @param  array $data The contents of $_POST['po_rule_data'].

	 * @return mixed Data collection of this rule.

	 */

	protected function save_url( $data ) {

		lib3()->array->equip( $data, 'url' );

		return $this->sanitize_values( $data['url'] );

	}





	/*============================*\

	================================

	==                            ==

	==           NO_URL           ==

	==                            ==

	================================

	\*============================*/





	/**

	 * Apply the rule-logic to the specified popup

	 *

	 * @since  1.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 * @return bool Decission to display popup or not.

	 */

	protected function apply_no_url( $data ) {

		$data = $this->sanitize_values( $data );

		$url = $this->current_url();



		return ! $this->check_url( $url, $data );

	}



	/**

	 * Output the Admin-Form for the active rule.

	 *

	 * @since  1.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 */

	protected function form_no_url( $data ) {

		$data = $this->sanitize_values( $data );

		$urls = implode( "\n", $data );

		?>

		<label for="po-rule-data-no-url">

			<?php _e( 'Nicht auf diesen URLs (eine pro Zeile):', 'popover' ); ?>

		</label>

		<textarea name="po_rule_data[no_url]" id="po-rule-data-no-url" class="block"><?php

			echo esc_html( $urls );

		?></textarea>

		<div><em>

		<?php

		_e( 'URLs sollten nicht "http://" oder "https://" enthalten.', 'popover' );

		?>

		</em></div>

		<?php

	}



	/**

	 * Update and return the $settings array to save the form values.

	 *

	 * @since  1.6

	 * @param  array $data The contents of $_POST['po_rule_data'].

	 * @return mixed Data collection of this rule.

	 */

	protected function save_no_url( $data ) {

		lib3()->array->equip( $data, 'no_url' );

		return $this->sanitize_values( $data['no_url'] );

	}





	/*======================================*\

	==========================================

	==                                      ==

	==           HELPER FUNCTIONS           ==

	==                                      ==

	==========================================

	\*======================================*/





	/**

	 * Sanitizes the data parameter so it can be savely used by other functions.

	 *

	 * @since  1.6

	 * @param  mixed $data

	 * @return array

	 */

	protected function sanitize_values( $data ) {

		if ( is_string( $data ) ) {

			$data = str_replace(

				array( 'http://', 'https://', ':80/', ':443/' ),

				'',

				$data

			);



			$data = explode( "\n", $data );

		} else if ( ! is_array( $data ) ) {

			$data = array();

		}



		return $data;

	}



	/**

	 * Returns the URL which can be defined by REQUEST[theform] or wp->request.

	 *

	 * @since  1.6

	 * @return string

	 */

	public function current_url() {

		global $wp;

		$current_url = '';



		if ( empty( $_REQUEST['thefrom'] ) ) {

			$current_url = lib3()->net->current_url();

		} else {

			$current_url = strtok( $_REQUEST['thefrom'], '#' );

		}



		return $current_url;

	}



	/**

	 * Tests if the $test_url matches any pattern defined in the $list.

	 *

	 * @since  1.6

	 * @param  string $test_url The URL to test.

	 * @param  array $list List of URL-patterns to test against.

	 * @return bool

	 */

	public function check_url( $test_url, $list ) {

		$response = false;

		$list = array_map( 'trim', $list );

		$test_url = strtok( $test_url, '#' );



		if ( empty( $list ) ) {

			$response = true;

		} else {

			foreach ( $list as $match ) {

				$match = preg_quote( strtok( $match, '#' ) );



				if ( false === strpos( $match, '://' ) ) {

					$match = '\w+://' . $match;

				}

				if ( substr( $match, -1 ) != '/' ) {

					$match .= '/?';

				} else {

					$match .= '?';

				}

				$exp = '#^' . $match . '$#i';

				$res = preg_match( $exp, $test_url );



				if ( $res ) {

					$response = true;

					break;

				}

			}

		}



		return $response;

	}



};



IncPopupRules::register( 'IncPopupRule_Url' );