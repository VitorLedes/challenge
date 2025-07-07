$(function() {

    $('.page-books').each(function () {

        var $self = $(this);
        var $clearFilters = $self.find('.clear-filters');
        var $filters = $self.find('.card-filters');
        var $statusSelect = $filters.find('#status');
        var $searchInput = $filters.find('#search');
        var $genreInput = $filters.find('#genre');
        
        $self.find('.filter-btn button').on('click', function () {
            $self.find('.card-filters').toggleClass('d-none');
        });

        $self.find('.card-filters').each(function () {
            var $this = $(this);

            if ($statusSelect.val() != '' || $searchInput.val() != '' || $genreInput.val() != '') {
                $this.removeClass('d-none');
            }

        });

        $clearFilters.on('click', function () {
            $statusSelect.val('');
            $searchInput.val('');
            $genreInput.val('');
            window.location.href = '/books';
        });      

    });

});