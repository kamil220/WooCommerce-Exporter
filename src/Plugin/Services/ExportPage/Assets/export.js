( function($) {

	$( '#woocommerce-exporter-form' ).submit( function( e ) {
		e.preventDefault();

		const _this = $( this );
		const _submit = $( this ).find( 'input[type="submit"]');
		const _nonce = _this.find( 'input[name="woocommerce-exporter_export-form"]' ).val();
		$.ajax({
			data: {
				action: 'woocommerce_importer_export_form',
				nonce: _nonce,
			},
			url: wpdesk.ajax_url,
			type: 'post',
			beforeSend: function() {
				_submit.val( _submit.data('loading-text') );
			},
			success: function( data ) {
				fetch(  wpdesk.plugin_url + data.data.file_path )
					.then(resp => resp.blob())
					.then(blob => {
						const url = window.URL.createObjectURL(blob);
						const a = document.createElement('a');
						a.style.display = 'none';
						a.href = url;
						a.download = 'product-list.csv';
						document.body.appendChild(a);
						a.click();
						window.URL.revokeObjectURL(url);
					})
					.catch(() => error.log( 'Unable to download the file.'));
			},
			error: function() {
				error.log( 'There was an error during the AJAX request.' );
			},
			complete: function() {
				_submit.val( _submit.data('default-text') );
			}
		})
	});

})(jQuery);
