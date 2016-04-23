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
		var $clientTitleTextInput = $( "body.post-type-bloom-client #title" ),
			$fName = $( "#client_first_name" ),
			$mName = $( "#client_middle_name" ),
			$lName = $( "#client_last_name" ),
			$nameFields = $( ".js-client-title" );

		// Our placeholder.
		if ( ! $clientTitleTextInput.val() ) {
			$clientTitleTextInput.val( "Enter name below" );
		}

		$clientTitleTextInput.css("color", "rgba(51, 51, 51, 0.5)").prop( "readonly", true );

		$nameFields.on( "keyup", function() {
			var newTitle = "";
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
			$clientTitleTextInput.val( newTitle );
		} );
	}

	/**
	 * Copy the date values to the post_title field.
	 * Used on: session
	 */
	function sessionTitleCopier() {
		var $sessionTitleTextInput = $( "body.post-type-bloom-session #title" ),
			$sessionDate = $( "#session_date" ),
			$clientDropdown = $( "#_bloom-client-dropdown" ),
			$titleElements = $( ".js-session-title" );

		// Our placeholder.
		if ( ! $sessionTitleTextInput.val() ) {
			$sessionTitleTextInput.val( "Choose client and date below" );
		}

		$sessionTitleTextInput.css("color", "rgba(51, 51, 51, 0.5)").prop( "readonly", true );

		if ( $clientDropdown.val() ) {
			updateTitleField();
		}

		$titleElements.on( "change", updateTitleField );

		function updateTitleField() {
			var newTitle = "";
			// Client Name.
			if ( $clientDropdown.val() ) {
				newTitle = $clientDropdown.find( ":selected" ).text();
			}
			// Date.
			if ( $sessionDate.val() ) {
				if ( newTitle ) {
					newTitle = newTitle + " | ";
				}
				newTitle = newTitle + $sessionDate.val();
			}

			$sessionTitleTextInput.val( newTitle );
		}
	}

	/**
	 * Update the "View Client" link with selected client.
	 * Used on: session
	 */
	function viewClientLinkDisplay() {
		var $clientDropdown = $( "#_bloom-client-dropdown" ),
			$viewClientLinkContainer = $( "#bloom-view-client-link-container" ),
			newName = '',
			oldName = '',
			newURL = '';

		var $viewClientLink = $viewClientLinkContainer.find( "a" );

		if ( $clientDropdown.val() ) {
			updateClientLink();
		}

		$clientDropdown.on( "change", updateClientLink );

		function updateClientLink() {
			if ( $clientDropdown.val() ) {
				newName = $clientDropdown.find( ":selected" ).data( "termname" );
				oldName = $viewClientLink.attr( "href" ).match( "post=(.*)&action");
				newURL = $viewClientLink.attr( "href" ).replace( oldName[1], newName );
				$viewClientLink.attr( "href", newURL );
				$viewClientLinkContainer.show();
			} else {
				$viewClientLinkContainer.hide();
			}
		}
	}

	/**
	 * Run all of our bits here.
	 */
	$( document ).ready( function() {
		clientTitleCopier();
		sessionTitleCopier();
		viewClientLinkDisplay();
	} );

} )( jQuery );