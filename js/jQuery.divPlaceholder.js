(function ($) {
	$(document).on('change keydown keypress input', '*[data-placeholder]', function() {
		if (this.textContent) {
			this.setAttribute('data-div-placeholder-content', 'true');
			this.setAttribute('data-p-placeholder-content', 'true');
			this.setAttribute('data-h1-placeholder-content', 'true');
			this.setAttribute('data-h2-placeholder-content', 'true');
		}
		else {
			this.removeAttribute('data-div-placeholder-content');			
			this.removeAttribute('data-p-placeholder-content');			
			this.removeAttribute('data-h1-placeholder-content');
			this.removeAttribute('data-h2-placeholder-content');
			
		}
	});
})(jQuery);
