<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta name="keywords" content="editor">
    <meta name="description" content="Descripcion"/>
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE-edge, chrome=1"/>
   <!--  <link rel="shortcut icon" sizes="50x50" href="img/conmebol.png"> -->
    <link rel="sitemap"  type="application/xml" tittle="Sitemap" href="sitemap.xml">
	<title>Cursos</title>
   
   
 
  
   <script src="../../js/jquery-2.1.3.min.js"></script>

   <script src="ckeditor.js"></script>
  <script src="samples/js/sample.js"></script>
  <!-- <link rel="stylesheet" href="samples/css/samples.css">
  <link rel="stylesheet" href="samples/toolbarconfigurator/lib/codemirror/neo.css"> -->
</head>
<body id="main">

<!-- <nav class="navigation-a">
  <div class="grid-container">
    <ul class="navigation-a-left grid-width-70">
      <li><a href="https://ckeditor.com/ckeditor-4/">Project Homepage</a></li>
      <li><a href="https://github.com/ckeditor/ckeditor-dev/issues">I found a bug</a></li>
      <li><a href="https://github.com/ckeditor/ckeditor-dev" class="icon-pos-right icon-navigation-a-github">Fork CKEditor on GitHub</a></li>
    </ul>
    <ul class="navigation-a-right grid-width-30">
      <li><a href="https://ckeditor.com/blog/">CKEditor Blog</a></li>
    </ul>
  </div>
</nav>

<header class="header-a">
  <div class="grid-container">
    <h1 class="header-a-logo grid-width-30">
      <a href="index.html"><img src="img/logo.svg" onerror="this.src='img/logo.png'; this.onerror=null;" alt="CKEditor Sample"></a>
    </h1>

    <nav class="navigation-b grid-width-70">
      <ul>
        <li><a href="index.html" class="button-a button-a-background">Start</a></li>
        <li><a href="toolbarconfigurator/index.html" class="button-a">Toolbar configurator <span class="balloon-a balloon-a-nw">Edit your toolbar now!</span></a></li>
      </ul>
    </nav>
  </div>
</header>
 -->
<main>
  <!-- <div class="adjoined-top">
    <div class="grid-container">
      <div class="content grid-width-100">
        <h1>Congratulations!</h1>
        <p>
          If you can see CKEditor below, it means that the installation succeeded.
          You can now try out your new editor version, see its features, and when you are ready to move on, check some of the <a href="#sample-customize">most useful resources</a> recommended below.
        </p>
      </div>
    </div>
  </div> -->
  <!-- <div class="adjoined-bottom">
    <div class="grid-container">
      <div class="grid-width-100"> -->
        <div id="editor">
          <h1>Hello world!</h1>
          <p>I'm an instance of <a href="https://ckeditor.com">CKEditor</a>.</p>
        </div>
      <!-- </div>
    </div> -->
  </div>
<button id="ver">ver</button>
  <!-- <div class="grid-container">
    <div class="content grid-width-100">
      <section id="sample-customize">
        <h2>Customize Your Editor</h2>
        <p>Modular build and <a href="https://ckeditor.com/docs/ckeditor4/latest/guide/dev_configuration.html">numerous configuration options</a> give you nearly endless possibilities to customize CKEditor. Replace the content of your <code><a href="../config.js">config.js</a></code> file with the following code and refresh this page (<strong>remember to clear the browser cache</strong>.html)!</p>
    <pre class="cm-s-neo CodeMirror"><code><span style="padding-right: 0.1px;"><span class="cm-variable">CKEDITOR</span>.<span class="cm-property">editorConfig</span> <span class="cm-operator">=</span> <span class="cm-keyword">function</span>( <span class="cm-def">config</span> ) {</span>
<span style="padding-right: 0.1px;"><span class="cm-tab"> </span><span class="cm-variable-2">config</span>.<span class="cm-property">language</span> <span class="cm-operator">=</span> <span class="cm-string">'es'</span>;</span>
<span style="padding-right: 0.1px;"><span class="cm-tab"> </span><span class="cm-variable-2">config</span>.<span class="cm-property">uiColor</span> <span class="cm-operator">=</span> <span class="cm-string">'#F7B42C'</span>;</span>
<span style="padding-right: 0.1px;"><span class="cm-tab"> </span><span class="cm-variable-2">config</span>.<span class="cm-property">height</span> <span class="cm-operator">=</span> <span class="cm-number">300</span>;</span>
<span style="padding-right: 0.1px;"><span class="cm-tab"> </span><span class="cm-variable-2">config</span>.<span class="cm-property">toolbarCanCollapse</span> <span class="cm-operator">=</span> <span class="cm-atom">true</span>;</span>
<span style="padding-right: 0.1px;">};</span></code></pre>
      </section>

      <section>
        <h2>Toolbar Configuration</h2>
        <p>If you want to reorder toolbar buttons or remove some of them, check <a href="toolbarconfigurator/index.html">this handy tool</a>!</p>
      </section>

      <section>
        <h2>More Samples!</h2>
        <p>Visit the <a href="https://sdk.ckeditor.com">CKEditor SDK</a> for a huge collection of samples showcasing editor features, with source code readily available to copy and use in your own implementation.</p>
      </section>

      <section>
        <h2>Developer's Guide</h2>
        <p>The most important resource for all developers working with CKEditor, integrating it with their websites and applications, and customizing to their needs. You can start from here:</p>
        <ul>
          <li><a href="https://ckeditor.com/docs/ckeditor4/latest/guide/dev_installation.html">Getting Started</a> &ndash; Explains most crucial editor concepts and practices as well as the installation process and integration with your website.</li>
          <li><a href="https://ckeditor.com/docs/ckeditor4/latest/guide/dev_advanced_installation.html">Advanced Installation Concepts</a> &ndash; Describes how to upgrade, install additional components (plugins, skins.html), or create a custom build.</li>
        </ul>
          <p>When you have the basics sorted out, feel free to browse some more advanced sections like:</p>
        <ul>
          <li><a href="https://ckeditor.com/docs/ckeditor4/latest/guide/dev_features.html">Functionality Overview</a> &ndash; Descriptions and samples of various editor features.</li>
          <li><a href="https://ckeditor.com/docs/ckeditor4/latest/guide/plugin_sdk_intro.html">Plugin SDK</a>, <a href="https://ckeditor.com/docs/ckeditor4/latest/guide/widget_sdk_intro.html">Widget SDK</a>, and <a href="https://ckeditor.com/docs/ckeditor4/latest/guide/skin_sdk_intro.html">Skin SDK</a> &ndash; Useful when you want to create your own editor components.</li>
        </ul>
      </section>

      <section>
        <h2>CKEditor JavaScript API</h2>
        <p>CKEditor boasts a rich <a href="https://ckeditor.com/docs/ckeditor4/latest/api/index.html">JavaScript API</a> that you can use to adjust the editor to your needs and integrate it with your website or application.</p>
      </section>
    </div>
  </div> -->
</main>

<!-- <footer class="footer-a grid-container">
  <div class="grid-container">
    <p class="grid-width-100">
      CKEditor &ndash; The text editor for the Internet &ndash; <a class="samples" href="https://ckeditor.com/">https://ckeditor.com</a>
    </p>
    <p class="grid-width-100" id="copy">
      Copyright &copy; 2003-2019, <a class="samples" href="https://cksource.com/">CKSource</a> &ndash; Frederico Knabben. All rights reserved.
    </p>
  </div>
</footer> -->
  <script>

  
 
//   CKEDITOR.editorConfig = function( config ) {
//   config.toolbar = [
//     { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
//     { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
//     { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
//     { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
//     '/',
//     { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
//     { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
//     { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
//     { name: 'insert', items: [ 'EasyImageUpload', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
//     '/',
//     { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
//     { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
//     { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
//     { name: 'about', items: [ 'About' ] }
//   ];
// };

CKEDITOR.editorConfig = function( config ) {
              config.toolbar = [
                { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'EasyImageUpload', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                { name: 'about', items: [ 'About' ] },
              ];

            }
 initSample();



$('#ver').click(function(){
 
  console.log(CKEDITOR.instances['editor'].getData())
})
  </script>

</body>
</html>