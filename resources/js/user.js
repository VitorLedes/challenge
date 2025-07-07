$(function() {

    $('.page-users').each(function () {
        console.log('askdjhas');
        var $self = $(this);
        var $clearFilters = $self.find('.clear-filters');
        var $filters = $self.find('.card-filters');
        var $searchInput = $filters.find('#search');
        
        $self.find('.filter-btn button').on('click', function () {
            $self.find('.card-filters').toggleClass('d-none');
        });

        $self.find('.card-filters').each(function () {
            var $this = $(this);

            if ($searchInput.val() != '') {
                $this.removeClass('d-none');
            }

        });

        $clearFilters.on('click', function () {
            $searchInput.val('');
            window.location.href = '/users';
        });      

    });

});