function selectContentOfLinkForShareFieldHTML()
{
    var linkForShareFieldHTML = document.querySelector('.link-for-share .link .link-field');
    linkForShareFieldHTML.focus();
    linkForShareFieldHTML.select();
}

document.onreadystatechange = function () {
    if (document.readyState == "complete") {
        selectContentOfLinkForShareFieldHTML();
    }
}