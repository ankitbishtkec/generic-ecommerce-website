function initializePage()
{
	var randomImage = '/images/wallpaper' + ( Math.floor(Math.random() * (1 - 1 + 1)) + 1 ).toString() + '.jpg';
	$('body').css({ 'background' : 'url( ' + globalAppFolderUrl + randomImage + ')','-webkit-background-size' : 'cover',
	'-moz-background-size': 'cover', '-o-background-size': 'cover', 'background-size' : 'cover'
	//,'background-size' : '100% 100%', 'background-repeat' : 'no-repeat'
	});
	//window.location.replace( globalUrl + '/tiffin/index/filters/location=Bellandur');//comment me
}
    