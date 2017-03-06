<?php $this->load->view("common/header");?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/common/index">首页</a></li>
        <li><a href="/admin"><?php echo $title[0];?></a></li>
        <li><a href="#"><?php echo $title[1];?></a></li>
    </ul>

</div>

<div class="rightinfo">
   <table class="tablelist">
      <tbody>
        <tr>
            <td>角色:</td>
            <td><?php echo $groups[$info['group_id']];?></td>
         </tr>
        <tr class="odd">
            <td>登录名:</td>
            <td><?php echo $info['name'];?></td>
        </tr>
        <tr>
            <td>姓名:</td>
            <td><?php echo $info['fullname'];?></td>
        </tr>
        <tr class="odd">
            <td>Email:</td>
            <td><?php echo $info['email'];?></td>
        </tr>
        <tr>
            <td>手机:</td>
            <td><?php echo $info['tel'];?></td>
        </tr>
        <tr class="odd">
            <td>描述：</td>
            <td><?php echo $info['describe'];?></td>
        </tr>
      </tbody>
    </table>
</div>
<?php $this->load->view("common/footer");?>
	</body>
</html>