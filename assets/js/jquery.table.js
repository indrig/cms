(function( $ ){

    $.fn.table = function(options)
    {
        this.total          = options['total'] | 0;
        this.per_page       = options['per_page'] | 10;
        this.page           = options['page'] | 1;
        this.dataUrl        = options['dataUrl'];
        this.load = function()
        {
            var self = this;
            $.ajax({
                url:  this.dataUrl,
                dataType: 'json'
            }).done(function(data)
            {
                /*self.total      = data['total'];
                self.per_page   = data['per_page'];
                self.page       = data['page'];

                self.addRows();
                */
                self.setData(data);
                //console.log(this);
            });
        };

        this.goToPage = function(i)
        {

        };

        this.setData = function(data)
        {
            this.total      = data['total'] | this.total;
            this.per_page   = data['per_page'] | this.per_page;
            this.page       = data['page'] | this.page;

            this.cleanRows();
            this.addRows(data);
        };

        this.cleanRows = function()
        {

        };

        this.addRows = function(rows)
        {
            $.find('tr:fest').after('<tr><td>1</td></tr>');
        };
        this.load();
        return this;
    };
})( jQuery );