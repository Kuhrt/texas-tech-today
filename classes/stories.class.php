<?php
/**
 * A collection of stories
 */
class Stories
{
  /**
   * @var string   $title   The title of the collection
   * @var Object[] $stories All the story objects
   */
  private $title;
  private $stories = array();

  /**
   * Constructor function
   *
   * @var string $title Title of the collection
   */
  function __construct($title = null)
  {
    $this->setTitle($title);
  }

  /**
   * Set the title of the collection
   *
   * @var string $title The title of the collection
   */
  public function setTitle($title)
  {
    // Setting the title to null if it's empty
    if (empty($title))
    {
      $this->title = null;
    } else {
      $this->title = ucwords($title);
    }
  }
  /**
   * Gets the title of the collection
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Adds a story to the collection
   *
   * @var Object $story A story object
   */
  public function addStory($story)
  {
    $this->stories[] = $story;
  }
  /**
   * Gets the array of stories from the collection
   * TODO: Add category filtering
   *
   * @return array All the stories in the collection
   */
  public function getStories()
  {
    return $this->stories;
  }
}

?>
