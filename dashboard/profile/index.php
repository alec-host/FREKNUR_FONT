<!DOCTYPE html>
<head>
  <title>profile</title>
  <link rel="stylesheet" type="text/css" media="all" href="css/styles.css">
  <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
</head>

<body>
  <div id="w">
    <div id="content" class="clearfix">
	  <p><b>PROFILE</b></p>
      <div id="userphoto"><img src="images/avatar.png" alt="default avatar"></div>

      <nav id="profiletabs">
        <ul class="clearfix">
          <li><a href="#activity">Activity</a></li>
          <li><a href="#settings">Settings</a></li>
        </ul>
      </nav>
      
      <section id="activity" class="hidden">
        <p>Latest Activity Log[s]:</p>
        
        <p class="activity">@10:15PM - Submitted a news article</p>
        
        <p class="activity">@9:50PM - Submitted a news article</p>
        
        <p class="activity">@8:15PM - Posted a comment</p>
        
        <p class="activity">@4:30PM - Added <strong>someusername</strong> as a friend</p>
        
        <p class="activity">@12:30PM - Submitted a news article</p>
      </section>
      
      <section id="settings" class="hidden">
        <p>Edit user settings:</p>
        
        <p class="setting"><span>Name <img src="images/edit.png" alt="*Edit*"></span> Joe Doe</p>
        
        <!--p class="setting"><span>Language <img src="images/edit.png" alt="*Edit*"></span> English(US)</p-->
        
        <p class="setting"><span>Change Password <img src="images/edit.png" alt="*Edit*"></span> *******</p>
        
        <p class="setting"><span>Connected Accounts <img src="images/edit.png" alt="*Edit*"></span> None</p>
      </section>
    </div><!-- @end #content -->
  </div><!-- @end #w -->
<script type="text/javascript">
$(function(){
  $('#profiletabs ul li a').on('click', function(e){
    e.preventDefault();
    var newcontent = $(this).attr('href');
    
    $('#profiletabs ul li a').removeClass('sel');
    $(this).addClass('sel');
    
    $('#content section').each(function(){
      if(!$(this).hasClass('hidden')) { $(this).addClass('hidden'); }
    });
    
    $(newcontent).removeClass('hidden');
  });
});
</script>
</body>
</html>