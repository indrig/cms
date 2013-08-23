(function( $ ){

    $.fn.table = function(options)
    {
        var self = this;
        this.total          = options['total'] | 0;
        this.per_page       = options['per_page'] | 10;
        this.page           = options['page'] | 1;
        this.dataUrl        = options['dataUrl'];
        this.pageRange      = options['pageRange'] | 9;
        //Tags
        this.pagination     = this.parent(1).find('.pagination');

        this.load = function(params)
        {
            var self = this;
            $.ajax({
                url:  this.makeDataUrl(params),
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
            this.load({page: i});
        };

        this.drawPagination = function()
        {
            var pageCount = Math.ceil(this.total / this.per_page),
                pageNumber = this.page, lowerBound, upperBound, offset, li, i, a;
            this.pagination.empty();
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
                for(i = lowerBound; i <= upperBound; i++)
                {
                    if(i == this.page)
                    {
                        li = $('<li class="active"></li>');
                    }
                    else

                    {
                        li = $('<li></li>');
                    }
                    a = $('<a href="#" data-page="'+i+'">'+i+'</a>').bind('click', this.paginationItemClick);
                    li.append(a);
                    this.pagination.append(li)
                }
            }
        };

        this.paginationItemClick = function(e)
        {
            e.preventDefault();
            var page = $(this).attr('data-page');
            if(page)
            {
                self.goToPage({'page': page});
            }
            return false;
        };

        this.makeDataUrl = function(params)
        {
            var url = this.dataUrl;

            url += (url.indexOf('?')>=0 ? '&' : '?');
            console.dir(params);
            if(params)
            {
                if(params.page)
                    url += 'page='+(params.page);

                console.dir(params.page);
            }
            console.dir(url);
            return url;
        };

        this.setData = function(data)
        {
            this.total      = data['total'] | this.total;
            this.per_page   = data['per_page'] | this.per_page;
            this.page       = data['page'] | this.page;

            this.cleanRows();
            this.addRows(data['data']);
            this.drawPagination();
            //console.log(this.QueryString);
        };

        this.cleanRows = function()
        {
            this.find('tr:not(:first)').remove();
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