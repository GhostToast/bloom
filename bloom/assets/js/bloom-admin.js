/**
 * Generic JS file for admin stuff.
 *
 * This is enqueued in admin.
 */

( function( $ ) {

/**
 * Copy the compiled name values to the post_title field.
 */
function clientTitleCopier() {
	var $titleTextInput = $( "#title" ),
		$fName = $( "#client_first_name" ),
		$mName = $( "#client_middle_name" ),
		$lName = $( "#client_last_name" ),
		$nameFields = $( ".js-client-title" );

	$titleTextInput.prop( "disabled", true );

	$nameFields.on( 'keyup', function() {
		var newTitle = '';
		// First.
		if ( $fName.val() ) {
			newTitle = $fName.val();
		}
		// Middle.
		if ( $mName.val() ) {
			if ( newTitle ) {
				newTitle = newTitle + " ";
			}
			newTitle = newTitle + $mName.val();
		}
		// Last.
		if ( $lName.val() ) {
			if ( newTitle ) {
				newTitle = newTitle + " ";
			}
			newTitle = newTitle + $lName.val();
		}
		$titleTextInput.val( newTitle );
	} );
}

	/**
	 * Run all of our bits here.
	 */
	$( document ).ready( function() {
		clientTitleCopier();
	} );

} )( jQuery );