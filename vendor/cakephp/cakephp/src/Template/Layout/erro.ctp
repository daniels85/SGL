<!DOCTYPE html>
<html>
	<head>
		<title>404</title>
		<style type="text/css">
			body{
				background-repeat: no-repeat;
				background-size: 100%;
			}
			.box{
				padding: 10px;
				margin-top: 25%;
				margin-top: 25%;
				color: green;
				text-align: center;
			}
			.typed-cursor{
			    opacity: 1;
			    -webkit-animation: blink 0.7s infinite;
			    -moz-animation: blink 0.7s infinite;
			    animation: blink 0.7s infinite;
			}
			@keyframes blink{
			    0% { opacity:1; }
			    50% { opacity:0; }
			    100% { opacity:1; }
			}
			@-webkit-keyframes blink{
			    0% { opacity:1; }
			    50% { opacity:0; }
			    100% { opacity:1; }
			}
			@-moz-keyframes blink{
			    0% { opacity:1; }
			    50% { opacity:0; }
			    100% { opacity:1; }
			}
		</style>
		<?php echo $this->Html->script('jquery-1.12.2.min.js'); ?>
		<script type="text/javascript" src="/webroot/js/typed-js/dist/typed.min.js"></script>
		<script>
		  $(function(){
      $(".element").typed({
        strings: ["First sentence.", "Second sentence."],
        typeSpeed: 0
      });
  });
		</script>
	</head>
	<body>
		<div class="element"></div>
		<div class="box">
				
			<div class="text">
				
			</div>

		</div>

	</body>
</html>