<ul class="nav" id="side-menu">
    <li class="nav-header">
    
    	<div class="dropdown profile-element">
    		<span>
    		     <img alt="image" class="img-circle" src="<?php echo $domain['static']['url']?>/admin/img/profile_small.jpg" />
    		</span>
    		<a data-toggle="dropdown" class="dropdown-toggle"
    			href="#"> 
    			<span class="clear"> 
    			<span class="block m-t-xs">
    			</span> <span class="text-muted text-xs block">&nbsp;&nbsp;<?php echo $userInfo['name']?> <b class="caret"></b></span> </span>
            </a>
            <ul class="dropdown-menu animated fadeInRight m-t-xs">
              <li><a href="/admin/set_admin">个人资料</a>
              </li>
              <li><a href="/login/out">安全退出</a>
              </li>
            </ul>
    		</span>
    		</a>
    	</div>
    	<div class="logo-element"></div>
    
    </li>
    
                    
    <?php if($menu): ?>
    <?php foreach($menu as $key=>$val):?>
        <li <?php echo $val['code'] == $left_active_code ? 'class="active"' : '' ?>  >
            <a href="javascript:;">
                <i class="<?php echo $val['class'];?>"></i> 
                <span class="nav-label"><?php echo $key;?></span>
            </a>
            <ul class="nav nav-second-level collapse <?php echo $val['code'] == $left_active_code ? 'in' : '' ?>">
                <?php if($val['list']):?>
                <?php foreach($val['list'] as $k=>$v):?>
                    <li <?php echo $v[0] == $left_active_method ? 'class="active"' : '' ?>>
                        <a href="<?php echo $v[0];?>"><?php echo $v[1];?></a>
                    </li>
                <?php endforeach;?>
                <?php endif;?>
            </ul>
        </li>
    <?php endforeach;?>
    <?php endif;?>
</ul>