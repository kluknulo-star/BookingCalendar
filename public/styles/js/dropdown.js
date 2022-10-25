var $dropdowns = getAll('.dropdown:not(.is-hoverable)');

if ($dropdowns.length > 0) {
    $dropdowns.forEach(function ($el) {
        $el.addEventListener('click', function (event) {
            event.stopPropagation();

            closeAllDropdowns($el);
        });
    });

    document.addEventListener('click', function (event) {
        closeDropdowns();
    });
}

function closeDropdowns() {
    $dropdowns.forEach(function ($el) {
        $el.classList.remove('is-active');
    });
}

function closeAllDropdowns($el) {
    $el.classList.contains('is-active') ? (
        $el.classList.remove('is-active')
    ) : (
        closeDropdowns(),
            $el.classList.add('is-active')
    );
}

// Utils
function getAll(selector) {
    let parent = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : document;

    return Array.prototype.slice.call(parent.querySelectorAll(selector), 0);
}