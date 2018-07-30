

// setup an "add a tag" link
var $addTagLink = $('<a href="#" class="btn btn-outline-success add_tag_link float-right"><i class="fas fa-plus-circle"></i> Einen Teilnehmer hinzufügen</a>');
var $newLinkLi = $('<li></li>').append($addTagLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    var $collectionHolder = $('ul.participants');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see code block below)
        addParticipantForm($collectionHolder, $newLinkLi);
    });

    $collectionHolder.find('li.item').each(function() {
        addTagFormDeleteLink($(this));
    });

});

function addParticipantForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');
    console.debug(index);

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index+1);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li class="item"></li>').append(newForm);

    // also add a remove button, just for this example
    $newFormLi.append('<a href="#" class="btn btn-outline-danger remove-participant"><i class="fas fa-minus-circle"></i> Teilnehmer löschen</a>');

    $newLinkLi.before($newFormLi);

    // handle the removal, just for this example
    $('.remove-participant').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });


}

function addTagFormDeleteLink($tagFormLi) {

    var $removeFormA = $('<a class="btn btn-outline-danger" href="#"><i class="fas fa-minus-circle"></i> Teilnehmer löschen</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
    });

}
