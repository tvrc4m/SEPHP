<!--/*loading*/-->
<div class="loading radius5" style="display:none">
  <img src="/Static/images/icon/loading.gif" />
  <span>正在加载...</span>
</div>
{if !$nomore}
<div id="more" class="center" style="padding-bottom: 68px;">
  <a class="btn btn-large btn-danger" style="width:200px" href="{$nexturl}">下一页</a>
</div>
{/if}
<div id="automore" class="center" style="display:none;float:left">
  <a class="btn btn-large btn-danger" style="width:100px">自动加载</a>
</div>
<script type="text/javascript" src="/Static/default/js/masonry.js"></script>
<script type="text/javascript" src="/Static/default/js/jquery.infinitescroll.js"></script>
{literal}
<script type="text/javascript">
        $(function() {
          //auto=false;
          var $container = $('#grid-content');
          $container.imagesLoaded(function(){
            $container.masonry({
            itemSelector : '.pin',
            isAnimated: true,
            gutterWidth: 5
              });
          });
          $container.infinitescroll({
              navSelector  : '#more',
              nextSelector : '#more a',
              itemSelector : '.pin',
              loading: {
                  finishedMsg: '正在努力载入中...',
                  finished:function(){
                    //if(auto) return;
                    // 取消scroll绑定
                    $(window).unbind('.infscr');
                    $('#more a').text('手动加载下一页');
                    //$('#automore').show();
                    //$('#automore').click(function(){
                     // $(window).bind('.infscr');
                    //  auto=true;
                    //});
                    $('#more').click(function(e){
                      e.preventDefault();
                      $(this).siblings('.loading').show();
                      $('#grid-content').infinitescroll('retrieve');
                      //$('#more a').infinitescroll('retrieve.infscr');
                      //$('#grid-content').infinitescroll('retrieve.infscr');
                      //$(document).trigger('retrieve.infscr');
                      return false;
                    });
                  },
                  img: '/Static/images/icon/loading.gif'
                }
              },
              function( newElements ) {
                var $newElems = $( newElements ).css({ opacity: 0});
                $newElems.imagesLoaded(function(){
                  $newElems.animate({ opacity: 1 });
                  $container.masonry( 'appended', $newElems, true);
                });
                $('.loading').hide();
                $('#more').show();
              }
          );
          ;
          //$('#grid-content').infinitescroll('binding','unbind');
          // 手动点击的元素

          
          // 如果没有下一页，去掉分页，隐藏more按钮
          $(document).ajaxError(function(e,xhr,opt){
            if (xhr.status == 404) $('#more').remove();
          });
        });
</script>
{/literal}