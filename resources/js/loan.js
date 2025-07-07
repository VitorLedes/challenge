$(function() {

    $('.page-loans').each(function () {

        var $self = $(this);
        var $clearFilters = $self.find('.clear-filters');
        var $filters = $self.find('.card-filters');
        var $userSearchInput = $filters.find('#user_search');
        var $bookSearchInput = $filters.find('#book_search');
        var $statusSearchSelect = $filters.find('#status_id');

        $self.find('.filter-btn button').on('click', function () {
            $self.find('.card-filters').toggleClass('d-none');
        });

        $self.find('.card-filters').each(function () {
            var $this = $(this);

            if ($userSearchInput.val() != '' || $bookSearchInput.val() != '' || $statusSearchSelect.val() != '') {
                $this.removeClass('d-none');
            }

        });

        $clearFilters.on('click', function () {
            $userSearchInput.val('');
            $bookSearchInput.val('');
            $statusSearchSelect.val('');
            window.location.href = '/loans';
        });      

    });

});