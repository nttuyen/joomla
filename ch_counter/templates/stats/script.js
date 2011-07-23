function submit_with_anchor( anchor )
{
	document.stats.action = document.stats.action.replace( /#.*$/, '' ) + '#' + anchor;
	document.stats.submit();
	return false;
}
