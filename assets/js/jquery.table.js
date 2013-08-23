(function( $ ){

    $.fn.table = function(options)
    {
        this.total          = options['total'] | 0;
        this.per_page       = options['per_page'] | 10;
        this.page           = options['page'] | 1;
        this.dataUrl        = options['dataUrl'];
        this.pageRange      = options['pageRange'] | 9;
        //Tags
        this.pagination     = this.parent(1).find('.pagination');

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

        this.drawPagination = function()
        {
            var pageCount = Math.ceil(this.total / this.per_page),
                pageNumber = this.page, lowerBound, upperBound, offset, li;
            if(this.total > this.per_page)
            {
                if (this.pageRange > pageCount) {
                    this.pageRange = pageCount;
                }

                var delta = Math.ceil(this.pageRange / 2);
                if (pageNumber - delta > pageCount - this.pageRange) {
                    lowerBound = pageCount - this.pageRange + 1;
                    upperBound = pageCount;
                } else {
                    if (pageNumber - delta < 0) {
                        delta = pageNumber;
                    }

                    offset     = pageNumber - delta;
                    lowerBound = offset + 1;
                    upperBound = offset + this.pageRange;
                }

                //li = $('<li class="disabled"><a href="#">&laquo;</a></li>');
                //this.pagination.append(li);
                for(var i = lowerBound; i <= upperBound; i++)
                {
                    if(i == this.page)
                    {
                        li = $('<li class="active"><a href="'+this.makePageUrl(i)+'">'+i+'</a></li>');
                    }
                    else

                    {
                        li = $('<li><a href="'+this.makePageUrl(i)+'">'+i+'</a></li>');
                    }
                    this.pagination.append(li);
                }
                //li = $('<li class="disabled"><a href="#">&raquo;</a></li>');
                //this.pagination.append(li);

                //console.dir(this.pagination);

            }
        };

        this.makePageUrl = function(page)
        {


            return this.dataUrl + '?page='+page;
        };

        this.setData = function(data)
        {
            this.total      = 10001;//data['total'] | this.total;
            this.per_page   = data['per_page'] | this.per_page;
            this.page       = 40;//data['page'] | this.page;

            this.cleanRows();
            this.addRows(data['data']);
            this.drawPagination();
        };

        this.cleanRows = function()
        {
            //this.find('tbody').empty();
        };

        this.addRows = function(rows)
        {
            //console.dir(rows);
            var i, j, row, cell, lastRow = this.find('tr:first');

            for(i in rows)
            {
                row = $('<tr>');
                for(j in rows[i])
                {
                    cell = $('<td>').html(rows[i][j])
                    row.append(cell);
                }
                lastRow = row.insertAfter(lastRow);
            }

        };
        this.load();
        return this;
    };
})( jQuery );