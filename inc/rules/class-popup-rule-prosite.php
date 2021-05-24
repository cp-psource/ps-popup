<?php

/*

Name:        PS Bloghosting

Plugin URI:  https://n3rds.work/piestingtal-source-project/ps-bloghosting/

Description: Bedingungen basierend auf den Details der PS Bloghosting Seiten (nur für Global PopUps verfügbar). <a href="https://n3rds.work/piestingtal-source-project/ps-bloghosting/" target="_blank">Mehr über PS Bloghosting &raquo;</a>

Author:      DerN3rd (WMS N@W)

Author URI:  https://n3rds.work

Type:        Rule

Rules:       Seite ist keine Bloghosting Pro Seite

Limit:       global, pro

Version:     1.1



NOTE: DON'T RENAME THIS FILE!!

This filename is saved as metadata with each popup that uses these rules.

Renaming the file will DISABLE the rules, which is very bad!

*/





class IncPopupRule_Prosite extends IncPopupRule {



	/**

	 * Initialize the rule object.

	 *

	 * @since  4.6

	 */

	protected function init() {

		$this->filename = basename( __FILE__ );



		// 'no_prosite' rule.

		$this->add_rule(

			'no_prosite',

			__( 'Seite ist keine Bloghosting Pro Seite', 'popover' ),

			__( 'Zeigt das PopUp an, wenn die Seite keine Bloghosting Pro-Seite ist.', 'popover' ),

			'',

			20

		);



		// -- Initialize rule.



		$this->is_active = function_exists( 'is_pro_site' );

	}





	/*================================*\

	====================================

	==                                ==

	==           NO_PROSITE           ==

	==                                ==

	====================================

	\*================================*/





	/**

	 * Apply the rule-logic to the specified popup

	 *

	 * @since  4.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 * @return bool Decission to display popup or not.

	 */

	protected function apply_no_prosite( $data ) {

		$prosite = function_exists( 'is_pro_site' ) && is_pro_site();

		return ! $prosite;

	}



	/**

	 * Output the Admin-Form for the active rule.

	 *

	 * @since  4.6

	 * @param  mixed $data Rule-data which was saved via the save_() handler.

	 */

	protected function form_no_prosite( $data ) {

		if ( ! $this->is_active ) {

			$this->render_plugin_inactive();

		}

	}





	/*======================================*\

	==========================================

	==                                      ==

	==           HELPER FUNCTIONS           ==

	==                                      ==

	==========================================

	\*======================================*/





	/**

	 * Displays a warning message in case the Membership plugin is not active.

	 *

	 * @since  1.0.0

	 */

	protected function render_plugin_inactive() {

		?>

		<div class="error below-h2"><p>

			<?php printf(

				__(

					'Diese Bedingung erfordert, dass das <a href="%s" target="_blank">' .

					'PS Bloghosting Plugin </a> installiert und aktiviert ist.', 'popover'

				),

				'https://n3rds.work/piestingtal-source-project/ps-bloghosting/'

			);?>

		</p></div>

		<?php

	}

};



IncPopupRules::register( 'IncPopupRule_Prosite' );

