# mobile-presentation-template
Display a sequence of JPGs in the context of an iphone, or different responsive screen sizes

Drop directories of JPGs into the application directory. The PHP script will identify all directories and display a link to view that directory's images. You can ignore directories in the index.php file. 

Changing the display type will determine if a mobile wrapper is placed around the images, or if they should stretch up to 100% of the device width.

Swipe works, arrow keys work, and clicking on the right and left edges will also navigate between images.

Slides have hash URLs for easy linking.

Add an attribute test-header="100", where 100px is the height of a fixed header of your image (allows for scrolling the contents but simulating a fixed top nav).

