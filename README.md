# kofi - PHP Framework

![alt tag](https://user-images.githubusercontent.com/81825913/257935500-16fdb07e-6851-4909-9a4f-0d973f32cbef.jpg)

A lightweight and module based PHP framework.

<h1>Why use kofi framework?</h1>
    <ol>
      <li>Simple code structure.</li>
      <li>Easy to modify.</li>
      <li>It only loads the required JS, CSS, PHP files, that's why it's lightweight.</li>
      <li>Easily create components for reusability.</li>
      <li>No need to worry about class organization</li>
    </ol>

<h1><b>Getting started using Apache with XAMPP.</b></h1>
    <ol class="mb-6">
      <li>Download the source code throught our git repository, url: <a href="https://github.com/ksagun/kofi">https://github.com/ksagun/kofi</a></li>
      <li>To start a server, download XAMPP with the latest PHP version 8.0 and up (Easy installation guide)</li>
      <li>
        Configure virtual hosts: Goto <b>C:/xampp/apache/conf/extra</b> and open
        <b>httpd-vhosts.conf</b>
      </li>
      <li>
        <p>Add the following code and save.</p>
        <pre>
          <code class="language-xml">
            &#60;VirtualHost *:80&#62;
              DocumentRoot "YOUR_PROJECT_PATH"
              ServerName your_preferred_server_name.com
              &#60;Directory YOUR_PROJECT_PATH&#62;
                  AllowOverride all
                  Require all granted  
              &#60;/Directory&#62;
            &#60;/VirtualHost&#62;
          </code>
        </pre>
      </li>
      <li>
        Now to make your virtual host work goto <b>C:/Windows/system32/drivers/etc</b> and open the
        <b>hosts</b> file
      </li>
      <li>
        <p>Add the following line and save.</p>
        <pre>
          <code class="language-xml">
            127.0.0.1   server_name_in_your_virtual_hosts
          </code>
        </pre>
      </li>
      <li>Start apache server and you're ready to start using kofi!</li>
    </ol>

<h1>Starting with <b>app.php</b></h1>

    <pre>
        <code class="language-php">
            include_once("classes/router.php");
            require_once("autoload.php"); 
        
            public function init(){
                $router = new Router([
                    "/" => [
                        "module" => new LandingPageModule, 
                        "guard" => new AuthGuard,
                        "form" => [
                            ["url" => "/submit", "method" => "GET", "invoke" => "invoke"],
                            ["url" => "/submit", "method" => "POST", "invoke" => "invoke2:rest"]
                        ],
                    ],
                    "error" => ["module" => new NotFoundPageModule]
                  ]);
                }
        </code>
    </pre>
    
<p>This is where we start adding <b>url path</b>, <b>modules</b>, <b>forms</b> and <b>guards</b> but guards and forms are optional.</p>
<p>Inorder for the path to work and be routable, you will need to create a module which acts as the page of your website.</p>

<h1><span style="color: #35cc88ea; font-weight: 700">kofi</span> cli</h1>
    <ol>
      <li>
        Download the cli here
        <a href="https://drive.proton.me/urls/2CEQFH4T3C#D8F2eR2JO240" target="_blank">https://drive.proton.me/urls/2CEQFH4T3C#D8F2eR2JO240</a>
      </li>
      <li>Place the folder named kofi-cli anywhere but we recommend to put it in C: if you are using windows</li>
      <li>Open file explorer then right click <b>This PC</b> click properties then at the right side click <b>Advanced system setting</b></li>
      <li>A dialog will open then click <b>Environment variables</b></li>
      <li>In <b>User variables</b> find the <b>path</b> variable then click edit</li>
      <li>Add the path of kofi-cli folder <b>C:\kofi-cli</b>, then click ok</li>
      <li>Now open cmd and go to the modules directory of <span>kofi</span> framework directory then execute command <b>kofi</b></li>
      <li>The cli will start you can now create modules and components!</li>
      <li>
        To create module enter <b>fi create module <i>new-page</i> </b>
      </li>
      <li>
        To create components enter <b>fi create component <i>new-component</i> </b>
      </li>
    </ol>

<h1>Module</h1>
<p>Modules are the heart of your website pages, this is where you add your html, css, javascript, components and start working.</p>
<p>
  kofi has a default module called <b>LandingPageModule</b>, from there you can see how modules
  are working within the router.
</p>

  <pre>
      <code class="language-php">
        include_once('landing-page.controller.php');
        include_once('landing-page.form.php');
        include_once('components/components.php');
          
        class LandingPageModule extends LandingPageController {
            public function init(){
                include_once('components/components.php');
                $components = new Components();
                $components->initComponents();
          
                include($this->template_name);
                define("CONTROLLER_JS", $this->js);
                define("CONTROLLER_STYLE", $this->style);
            }
            public function initForm(){
                $form = new LandingPageForm([]);
                return $form;
            }
        }
      </code>
  </pre>

<p>Modules initializes your html, css, javascript, form, controller and components and acting as a wrapper.</p>
<p>
  From the <b>app.php</b>, we have set a / path in the router and set the
  <b>LandingPageModule</b> in the module array key, so when the user navigates to / the router
  will load the <b>LandingPageModule</b> and load the files associated with it.
</p>

<p>
  <b>*NOTE: When creating a module you must follow the file naming convention below to make it readable and easy to understand.</b>
</p>

<ol>
    <li>Module(directory): user-page</li>
    <li>Controller: user-page.controller.js and user-page.controller.php</li>
    <li>View: user-page.view.html</li>
    <li>Form: user-page.form.php</li>
    <li>CSS: user-page.style.css</li>
</ol>

<h1>Controller</h1>
<p>
Controller is where you do the business logic of your page and is inherited in module class so all the code in your controller is accessible in
the current page.
</p>

<p>The html, css and js file names are also initialized in the controller, you can modify the code structure if you like.</p>

<pre>
    <code class="language-php">
        class LandingPageController {
          public string $template_name = "landing-page.view.html";
          public string $style = "landing-page/landing-page.style.css";
          public string $js = "landing-page/landing-page.controller.js";
          
          public function clearSetSession($key){
              unset($_SESSION[$key]);
          }
        }
    </code>
</pre>

<h1>Form</h1>
<p>Form is where you send your http request to server, the form class will be called when you add the "form" key in the router.</p>

<p>
    Inorder for a form to work you must specify a function name from the <b>landing-page.form.php</b> in the invoke key in router, the function will
    be triggered when the url meets the condition.
</p>

<pre>
    <code class="language-php">
      include_once($_SERVER['DOCUMENT_ROOT']."/src/classes/httproutes.php");
      class LandingPageForm extends HttpRoutes{

        private $data = [];

        public function __construct($data)
        {
            $this->current_route = $_SERVER['REQUEST_URI'];
            // Get the passed data
            if(is_array($data) && count($data) > 0){
                $this->data = $data;
            }
        }

        public function invoke(){
            echo "You invoked a function!";
        }

        public function invoke2(){
            echo "You invoked the second function!";
        }
      }
    </code>
</pre>

<h1>Components</h1>
<p>
      Components are reusable elements within the module that provide specific functionalities. They are designed to encapsulate logic and
      presentation to promote code reusability and maintainability. Components can be easily loaded in PHP files using the component.php file.
</p>

<p>Components should be organized in a specific folder within the module directory. The recommended folder structure is as follows:</p>

<pre>
      <code class="language-xml"> 
        - module
          - sample-page
            - components
              - custom-button
                custom-button.component.html
                custom-button.component.php
              - cards
                cards.component.html
                cards.component.php
              components.php
      </code>
</pre>
<p>Each component should have its own directory with the necessary files.</p>
<p>
      Define the HTML markup for the component in the .your-component-name.components.php file. This file will serve as the main entry point for the
      component.
</p>
<p>Include <span>components.php</span> in the index.php of your module to autoload all components.</p>
