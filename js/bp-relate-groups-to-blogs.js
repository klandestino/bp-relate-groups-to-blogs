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
		var list = $( '#group-blog-result' );
		list.find( '*:not( .group-blog-template ):has( input[ checked!="checked" ] )' ).remove();

		for( var i = 0, l = data.length; i < l; i++ ) {
			if( list.find( '#group-blog-' + data[ i ].blog_id ).length == 0 ) {
				var blog = list.find( '.group-blog-template' ).clone();
				blog.removeClass( 'group-blog-template' );
				blog.attr( 'id', 'group-blog-' + data[ i ].blog_id );

				for( var ii in data[ i ] ) {
					var re = RegExp( '%' + ii, 'g' );
					blog.html( blog.html().replace( re, data[ i ][ ii ] ) );
				}

				list.append( blog );
			}
		}
	}

	$( '#group-blog-search' ).keydown( searchByTimeout );

} );
