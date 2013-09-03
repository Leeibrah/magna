<script type="text/javascript">
//doublescroll
if( $('.doublescroll')['0'] != undefined){
    function DoubleScroll(element) {
        var scrollbar= document.createElement('div');
        scrollbar.appendChild(document.createElement('div'));
        scrollbar.style.overflow= 'auto';
        scrollbar.style.overflowY= 'hidden';
        scrollbar.firstChild.style.width= element.scrollWidth+'px';
        scrollbar.firstChild.style.paddingTop= '1px';
        scrollbar.firstChild.appendChild(document.createTextNode('\xA0'));
        scrollbar.onscroll= function() {
            element.scrollLeft= scrollbar.scrollLeft;
        };
        element.onscroll= function() {
            scrollbar.scrollLeft= element.scrollLeft;
        };
        element.parentNode.insertBefore(scrollbar, element);
    }

    DoubleScroll($('.doublescroll').parent()['0']);
    $('#doublescroll').css('overflow-x', 'scroll');
  }


   jQuery('.btn-danger').click(function(evnt) {
        evnt.preventDefault();
        var title = "Confirm";
        var message = "Are you sure you want to delete?";
        var btn = $(this);
        console.log(btn);

        function formSubmit(){
            btn.parent('form').submit();
        }

        if (!jQuery('#dataConfirmModal').length) {
            jQuery('body').append('<div id="dataConfirmModal" \
             class="modal fade" role="dialog" aria-labelledby="dataConfirmLabel" \
             aria-hidden="true"><div class="modal-header"> \
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">× \
             </button><h3 id="dataConfirmLabel">'+title+'</h3></div><div class="modal-body"> \
             '+message+'</div><div class="modal-footer"><button class="btn btn-success" \
              data-dismiss="modal" aria-hidden="true">No</button><a class="btn btn-danger"  \
              data-dismiss="modal" id="dataConfirmOK">Yes</a></div> \
              </div>');
        } 

        jQuery('#dataConfirmModal').find('.modal-body').text(message);
        jQuery('a#dataConfirmOK').on('click', function(){
            formSubmit();
        });
        jQuery('#dataConfirmModal').modal({show:true});

    })

  </script>
