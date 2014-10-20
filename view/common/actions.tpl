 <div class="operpanel clearfix">
          <div class="oper-item">
            {if !empty($haslike)}
              <a class="btn btn-success btn-small count operunlike" href="javascript:void(0);" onclick="unlikeItemDetail(this,'{$iid}','.amount',{$itemdetail['likenum']})"> <i></i>
                已赞
              </a>
              <a class="btn btn-success btn-small count operlike" style="display:none" href="javascript:void(0);" onclick="likeItemDetail(this,'{$iid}','.amount',{$itemdetail['likenum']})"> <i></i>
                有赞
              </a>
            {else}
              <a class="btn btn-success btn-small count operunlike" style="display:none" href="javascript:void(0);" onclick="unlikeItemDetail(this,'{$iid}','.amount',{$itemdetail['likenum']})"> <i></i>
                已赞
              </a>
              <a class="btn btn-success btn-small count operlike" href="javascript:void(0);" onclick="likeItemDetail(this,'{$iid}','.amount',{$itemdetail['likenum']})"> <i></i>
                有赞
              </a>
            {/if}
            <span class="amount-panel"> <i class="angle angle-left"><i class="angle-outer"></i>
                <i class="angle-inner"></i></i> 
              +
              <span class="amount">{$itemdetail['likenum']}</span>
            </span>
          </div>
          <div class="oper-item">
            <a class="btn btn-success btn-small count opercomment" href="javascript:void(0);" onclick="commentDetailAction()"> <i></i>
              评论
            </a>
            <span class="amount-panel"> <i class="angle angle-left"><i class="angle-outer"></i>
                <i class="angle-inner"></i></i> 
              +
              <span class="amount">{$itemdetail['commentnum']}</span>
            </span>
          </div>
          <div class="oper-item">
            <a class="btn btn-success btn-small count operfav" href="javascript:void(0);" onclick="favItem(this,'{$iid}','.amount',{$itemdetail['favnum']})"> <i></i>
              收藏
            </a>
            <span class="amount-panel"> <i class="angle angle-left"><i class="angle-outer"></i>
                <i class="angle-inner"></i></i> 
              +
              <span class="amount">{$itemdetail['favnum']}</span>
            </span>
          </div>
          <div class="oper-item">
            <a class="btn btn-success btn-small count operwant" href="javascript:void(0);" onclick="wantItem(this,'{$iid}','.amount',{$itemdetail['wantnum']})">
              <i></i>
              想要
            </a>
            <span class="amount-panel">
              <i class="angle angle-left"><i class="angle-outer"></i>
                <i class="angle-inner"></i></i> 
              +
              <span class="amount J_amount_want">{$itemdetail['wantnum']}</span>
            </span>
          </div>
      </div>