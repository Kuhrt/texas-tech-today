<?php
/**
 * This is an individual story
 */
class Story
{
  /**
   * @var string   $title       The title of the story
   * @var string   $url         The URL to the story
   * @var string   $author      The author of the story
   * @var DateTime $publishDate Date object for when the story was published
   * @var string   $description A short description of the story
   * @var string[] $categories  Array of categories for the story
   * @var string   $image       URL to the story's image
   */
  private $title;
  private $url;
  private $author;
  private $publishDate;
  private $description;
  private $categories;
  private $image;

  /**
   * Constructs the story with its details
   *
   * @var Object $story A SimpleXMLElement object that has all the story's information
   * @var Object $namespaces Has the namespaces for the $story objects
   */
  function __construct($story, $namespaces)
  {
    // Setting the story information from the story object
    $this->setTitle($story->title);
    $this->setUrl($story->link);
    $this->setAuthor($story->author);
    $this->setDate($story->pubDate);
    $this->setDescription((string)$story->description);
    $this->setCategories($story->category);

    // Setting the story's image with the namespaces url if the media namespace exists
    if ($story->children($namespaces['media'])) {
      $imageLink = $story->children($namespaces['media'])->content->attributes()->url;
      $this->setImage($imageLink);
    }

  }

  /**
   * Sets the title of the story
   *
   * @var string $title The title of the story
   */
  public function setTitle($title)
  {
    $this->title = ucwords($title);
  }
  /**
   * Gets the title of the story
   *
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Sets the URL for the story
   *
   * @var string $url The url where the story exists
   */
  public function setUrl($url)
  {
    $this->url = htmlspecialchars($url);
  }
  /**
   * Gets the URL of the story
   *
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   * Sets the author of the story
   *
   * @var string $author The author of the story
   */
  public function setAuthor($author)
  {
    $this->author = $author;
  }
  /**
   * Gets the author of the story
   *
   */
  public function getAuthor()
  {
    return $this->author;
  }

  /**
   * Sets the date of the story
   *
   * @var string $date The date of when the story was published
   */
  public function setDate($date)
  {
    $this->publishDate = new DateTime($date);
  }
  /**
   * Gets the date of the story
   *
   */
  public function getDate()
  {
    return $this->publishDate;
  }

  /**
   * Sets the description of the story
   *
   * @var string $description The description of the story
   */
  public function setDescription($description)
  {
    $this->description = $description;
  }
  /**
   * Gets the description of the story
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Sets the categories for the story
   *
   * @var Object[] $categories The categories for the story
   */
  public function setCategories($categories)
  {
    // Variable to hold the categories as strings
    $catList = array();

    // Looping through each category item and pushing to array
    foreach ($categories as $cat)
    {
      array_push($catList, trim($cat));
    }

    // Setting categories to the array
    $this->categories = $catList;
  }
  /**
   * Gets the categories for the story
   *
   */
  public function getCategories()
  {
    return $this->categories;
  }

  /**
   * Sets the url of the image for the story
   *
   * @var string $image The url path to the image
   */
  public function setImage($image)
  {
    // Initializing the curl request to get the image from the URL
    $ch = @curl_init($image);
    // Setting the necessary options
    @curl_setopt($ch, CURLOPT_HEADER, TRUE);
    @curl_setopt($ch, CURLOPT_NOBODY, TRUE);
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    // Variable to hold HTTP statuses from getting the image
    $status = array();
    preg_match('/HTTP\/.* ([0-9]+) .*/', @curl_exec($ch) , $status);

    // Making sure the image is there by getting a 200 OK response,
    // then setting the story's image to this image. If we don't get a 200 response,
    // this story doesn't have an image so we set it to a default image.
    if($status[1] == 200)
    {
      $this->image = $image;
    } else {
      $this->image = "http://placehold.it/1280x485&amp;text=Image+Not+Available";
    }
  }
  /**
   * Gets the url of the image
   */
  public function getImage()
  {
    return $this->image;
  }

}

?>
