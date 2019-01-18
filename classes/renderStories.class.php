<?php
include('stories.class.php');

/**
 * Controls the visual output of news stories
 *
 */
class RenderStories
{
  /**
   * @var int    $feedSize The number of stories to display
   */
  private $feedSize;

  /**
   * Constructor function
   *
   * @var int    $feedSize The number of stories to display
   */
  function __construct($feedSize = 4)
  {
    $this->setFeedSize($feedSize);
  }

  /**
   * Sets how many stories to show
   *
   * @var int $size The number of stories to display
   */
  public function setFeedSize($size = null)
  {
    $this->feedSize = $size;
  }

  /**
   * Outputs the HTML for the feature slider
   *
   * @var    Object[] $stories The array of stories to show
   * @return string   $output  HTML to display on the page
   */
  public static function displayFeatureSlider($stories, $feedSize = 4)
  {

    // Variable to store the HTML to display
    $output = "<div class=\"feature-stories slider\">";

    // Create a slide for each of the stories in the list
    for ($i=0; $i < $feedSize; $i++)
    {
      $output .= "<article class=\"feature-story\">";
      $output .= "<a href=\"" . $stories[$i]->getUrl() . "\">";
      $output .= "<div class=\"feature-story__photo\" style=\"background-image: url('" . $stories[$i]->getImage() . "');\"></div>";
      $output .= "</a>";
      $output .= "<div class=\"feature-story__info\">";
      $output .= "<h2><a href=\"" . $stories[$i]->getUrl() . "\">" . $stories[$i]->getTitle() . "</a></h2>";
      $output .= "<p>" . $stories[$i]->getDescription() . "</p>";
      $output .= "<p class=\"read-more\"><a href=\"" . $stories[$i]->getUrl() . "\">Read More</a></p>";
      $output .= "</div>";
      $output .= "</article>";
    }

    $output .= "<button type=\"button\" name=\"feature-next-button\" class=\"feature-story__next next-story\">Next Story</button>";
    $output .= "</div>";

    return $output;
  }

  /**
   * Outputs the HTML for the recent stories section
   *
   * @var    Object[] $stories The array of stories to show
   * @return string   $output  HTML to display on the page
   */
  public static function listRecentStories($stories)
  {
    // Variable to store the HTML to display
    $output = "<section id=\"recent-stories\" class=\"slider\">";
    $output .= "<h2>Recent Stories</h2>";
    $output .= "<div class=\"recent-stories__grid\">";

    for ($i=0; $i < 4; $i++)
    {
      $output .= "<article class=\"recent-story\">";
      $output .= "<a href=\"" . $stories[$i]->getUrl() . "\">";
      $output .= "<p class=\"recent-story__category\">" . $stories[$i]->getCategories()[0] . "</p>";
      $output .= "<h3>" . $stories[$i]->getTitle() . "</h3>";
      $output .= "<p class=\"recent-story__date\">" . $stories[$i]->getDate()->format('M j, Y') . "</p>";
      $output .= "</a>";
      $output .= "</article>";
    }

    $output .= "</div>";
    $output .= "</section>";

    return $output;
  }
}

?>
