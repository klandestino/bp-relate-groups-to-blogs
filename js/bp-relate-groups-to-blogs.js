jQuery( function( $ ) {

	/**
	 * Executes a search by timeout
	 * @returns void
	 */
	function searchByTimeout() {
		var e = $( this );
		clearTimeout( e.data( 'search-timeout' ) );

		var timeout = setTimeout( function() {
			search.apply( e );
		}, 1000 );

		e.data( 'search-timeout', timeout );
	}

	/**
	 * Executes an ajax search for blogs
	 */
	function search() {
		var e = $( this ), val = e.val().replace( /\s+/g, ' ' ).replace( /^\s|\s$/, '' );
		if( e.data( 'search-last' ) != val && val.length > 0 ) {
			e.data( 'search-last', val );
			$.ajax( ajaxurl, {
				type: 'POST',
				data: {
					action: 'get_blogs',
					cookie: encodeURIComponent( document.cookie ),
					query: val
				},
				dataType: 'json',
				success: $.proxy( results, e )
			} );
			e.addClass( 'working' );
		}
	}

	/**
	 * Taking care of results
	 */
	function results( data ) {
		$( this ).removeClass( 'working' );
		$( 'ul#group-blog-result li:[checked=false]' ).remove();

		for( var i = 0, l = data.length; i < l; i++ ) {
			$( 'ul#group-blog-result' ).append( '<li><input id="group-blog-id-' + data[ i ].blog_id + '" name="group-blog-blogs[]" type="checkbox" value="' + data[ i ].blog_id + '" /><label for="group-blog-id-' + data[ i ].blog_id + '">' + data[ i ].domain + '</label></li>' );
		}
	}

	$( 'input#group-blog-search' ).keydown( searchByTimeout );

} );
