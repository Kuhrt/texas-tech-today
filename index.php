<!DOCTYPE html>
<html>
    <head>
        <?php include 'includes/ttu-head.html'; ?>
        <title>Texas Tech Today | TTU</title>
        <meta name="Description" content="The official news source for Texas Tech University.">
    </head>
    <body>
        <?php include 'includes/ttu-body-top.php'; ?>


        <!-- ADD MAIN CONTENT BELOW THIS LINE -->
  			<?php

          include('includes/classes/featureStory.class.php');
          include('includes/classes/renderStories.class.php');
    		  $tmp['tags'] = "Feature Stories";
    		  $tmp['limit'] = 4;
    		  $tmp['display_type'] = 'array';
    		  $featureFeed = display($posts,$tmp);

    		  $tmp['limit'] = 10;
    		  $tmp['tags'] = "-!Texas Tech in the News,-!Feature Stories,-!Videos";
    		  $feed = display($posts,$tmp);

    		  $tmp['limit'] = 4;
    		  $tmp['tags'] = "Videos,-!Feature Stories,-!Texas Tech in the News";
    		  $videos = display($posts,$tmp);

    		  // Creating a collection of feature stories
          $featureStories = new Stories('Feature Stories');
    		  $moreStories = new Stories('More Stories'); //stories with images
    		  $recentStories = new Stories('Recent Stories');
    		  $videoStories = new Stories('Video Stories');
          // Looping through the feature XML data
          foreach($featureFeed as $item) {
              // Creating an individual story from the XML
              $story = new FeatureStory((object)$item, "");
              // Adding it to the $featureStories collection
              $featureStories->addStory($story);
          }

    		  $x=0;
          foreach($feed as $item) {
    				// Creating an individual story from the XML
    				$story = new Story((object)$item, "");
    				if($item['image']['display'] == 'true' && $x < 5) {
    					$moreStories->addStory($story);
    					$x++;
    				} else {
    					$recentStories->addStory($story);
    				}
          }
    		  foreach($videos as $item) {
    			  $story = new Story((object)$item, "");
    			  $videoStories->addStory($story);
    		  }

  		  ?>
    		<section id="t3-header">
                <div class="header-title">
                    <h1 aria-label="Texas Tech Today">Texas<br />Tech<br />Today</h1>
                    <p class="todays-date">
                        <?php echo date('l, F j'); ?>
                    </p>
                </div>
                <?php
                echo RenderStories::displayFeatureSlider($featureStories->getStories());
      			  ?>
            </section>
    		<section id="t3-home-stories">
        		<?php
                  echo RenderStories::listMoreStories($moreStories->getStories());
                ?>
            <section id="other-stories">
                <?php
                echo RenderStories::listRecentStories($recentStories->getStories());
                echo RenderStories::listVideoStories($videoStories->getStories());
                ?>
            </section>
            <script src="includes/app.js"></script>
        </section>
		<!-- ADD MAIN CONTENT ABOVE THIS LINE -->




        <?php include 'includes/ttu-body-bottom.php'; ?>
    </body>
</html>
