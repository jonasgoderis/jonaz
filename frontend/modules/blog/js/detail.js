/**
 * Interaction for the location module
 *
 * @author Tijs Verkoyen <tijs@sumocoders.be>
 */
jsFrontend.blog =
{
	init: function()
	{
		if($("#imageThumbs").length > 0)
		{
			jsFrontend.blog.initDependencies();
		}
	},

	initDependencies: function()
	{
		$("#imageThumbs img").on('click', function()
		{
			var source = $(this).data('source');

			console.log(source);
			$('img.blogDetailImage').attr('src', source);
		});
	}
}

$(jsFrontend.blog.init);