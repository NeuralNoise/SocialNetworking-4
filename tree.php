
<?php
session_start();
require 'Gateway/FindRelativesClass.php';
$Find = new Findrelatives();
$author_id = $_SESSION['id'];
$wife = $Find->partner($author_id);
//    var_dump($_SESSION);
?>
<html>
    <head>
        <title>Decision Tree</title>
        <meta name="description" content="Interactive decision diagram with automatic expansion as the user makes choices." />
        <!-- Copyright 1998-2016 by Northwoods Software Corporation. -->
        <meta charset="UTF-8">
        <script src="js/go.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/blog-home.css">
        <link rel="stylesheet" href="css/light-theme.css">
        <link rel="stylesheet" href="css/profile.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <script src="goSamples.js"></script>  <!-- this is only for the GoJS Samples framework -->
        <script id="code">
            function init() {
                if (window.goSamples)
                    goSamples();  // init for these samples -- you don't need to call this
                var $ = go.GraphObject.make;  // for conciseness in defining templates
                myDiagram = $(go.Diagram, "myDiagramDiv", // must name or refer to the DIV HTML element
                        {
                            initialContentAlignment: go.Spot.Left,
                            allowSelect: false, // the user cannot select any part
                            // create a TreeLayout for the decision tree
                            layout: $(go.TreeLayout)
                        });
                // custom behavior for expanding/collapsing half of the subtree from a node
                function buttonExpandCollapse(e, port) {
                    var node = port.part;
                    node.diagram.startTransaction("expand/collapse");
                    var portid = port.portId;
                    node.findLinksOutOf(portid).each(function (l) {
                        if (l.visible) {
                            // collapse whole subtree recursively
                            collapseTree(node, portid);
                        } else {
                            // only expands immediate children and their links
                            l.visible = true;
                            var n = l.getOtherNode(node);
                            if (n !== null) {
                                n.location = node.getDocumentPoint(go.Spot.TopRight);
                                n.visible = true;
                            }
                        }
                    });
                    myDiagram.toolManager.hideToolTip();
                    node.diagram.commitTransaction("expand/collapse");
                }
                // recursive function for collapsing complete subtree
                function collapseTree(node, portid) {
                    node.findLinksOutOf(portid).each(function (l) {
                        l.visible = false;
                        var n = l.getOtherNode(node);
                        if (n !== null) {
                            n.visible = false;
                            collapseTree(n, null);  // null means all links, not just for a particular portId
                        }
                    });
                }
                // get the text for the tooltip from the data on the object being hovered over
                function tooltipTextConverter(data) {
                    var str = "";
                    var e = myDiagram.lastInput;
                    var currobj = e.targetObject;
                    if (currobj !== null && (currobj.name === "ButtonA" ||
                            (currobj.panel !== null && currobj.panel.name === "ButtonA"))) {
                        str = data.aToolTip;
                    } else {
                        str = data.bToolTip;
                    }
                    return str;
                }
                // define tooltips for buttons
                var tooltipTemplate =
                        $(go.Adornment, "Auto",
                                $(go.Shape, "Rectangle",
                                        {fill: "whitesmoke", stroke: "lightgray"}),
                                $(go.TextBlock,
                                        {
                                            font: "8pt sans-serif",
                                            wrap: go.TextBlock.WrapFit,
                                            desiredSize: new go.Size(200, NaN),
                                            alignment: go.Spot.Center,
                                            margin: 6
                                        },
                                        new go.Binding("text", "", tooltipTextConverter))
                                );
                // define the Node template for non-leaf nodes
                myDiagram.nodeTemplateMap.add("decision",
                        $(go.Node, "Auto",
                                new go.Binding("text", "key"),
                                // define the node's outer shape, which will surround the Horizontal Panel
                                $(go.Shape, "Rectangle",
                                        {fill: "whitesmoke", stroke: "lightgray"}),
                                // define a horizontal Panel to place the node's text alongside the buttons
                                $(go.Panel, "Horizontal",
                                        $(go.TextBlock,
                                                {font: "30px Roboto, sans-serif", margin: 5},
                                                new go.Binding("text", "key")),
                                        // define a vertical panel to place the node's two buttons one above the other
                                        $(go.Panel, "Vertical",
                                                {defaultStretch: go.GraphObject.Fill, margin: 3},
                                                $("Button", // button A
                                                        {
                                                            name: "ButtonA",
                                                            click: buttonExpandCollapse,
                                                            toolTip: tooltipTemplate
                                                        },
                                                        new go.Binding("portId", "a"),
                                                        $(go.TextBlock,
                                                                {font: '500 16px Roboto, sans-serif'},
                                                                new go.Binding("text", "aText"))
                                                        ), // end button A
                                                $("Button", // button B
                                                        {
                                                            name: "ButtonB",
                                                            click: buttonExpandCollapse,
                                                            toolTip: tooltipTemplate
                                                        },
                                                        new go.Binding("portId", "b"),
                                                        $(go.TextBlock,
                                                                {font: '500 16px Roboto, sans-serif'},
                                                                new go.Binding("text", "bText"))
                                                        )  // end button B
                                                )  // end Vertical Panel
                                        )  // end Horizontal Panel
                                ));  // end Node and call to add
                // define the Node template for leaf nodes
                myDiagram.nodeTemplateMap.add("personality",
                        $(go.Node, "Auto",
                                new go.Binding("text", "key"),
                                $(go.Shape, "Rectangle",
                                        {fill: "whitesmoke", stroke: "lightgray"}),
                                $(go.TextBlock,
                                        {font: '13px Roboto, sans-serif',
                                            wrap: go.TextBlock.WrapFit, desiredSize: new go.Size(200, NaN), margin: 5},
                                        new go.Binding("text", "text"))
                                ));
                // define the only Link template
                myDiagram.linkTemplate =
                        $(go.Link, go.Link.Orthogonal, // the whole link panel
                                {fromPortId: ""},
                                new go.Binding("fromPortId", "fromport"),
                                $(go.Shape, // the link shape
                                        {stroke: "lightblue", strokeWidth: 2})
                                );
                // create the model for the decision tree
                var model =
                        $(go.GraphLinksModel,
                                {linkFromPortIdProperty: "fromport"});
                // set up the model with the node and link data
                makeNodes(model);
                makeLinks(model);
                myDiagram.model = model;
                // make all but the start node invisible
                myDiagram.nodes.each(function (n) {
                    if (n.text !== "ROOT")
                        n.visible = false;
                });
                myDiagram.links.each(function (l) {
                    l.visible = false;
                });
            }
            function makeNodes(model) {
                var nodeDataArray = [
                    {key: "ROOT"}, // the root node
                    // intermediate nodes: decisions on personality characteristics

                    {key: "A"},
                    {key: "B"},
                    {key: "AC"},
                    {key: "AD"},
                    {key: "BC"},
                    {key: "BD"},
                ];
                // Provide the same choice information for all of the nodes on each level.
                // The level is implicit in the number of characters in the Key, except for the root node.
                // In a different application, there might be different choices for each node, so the initialization would be above, where the Info's are created.
                // But for this application, it makes sense to share the initialization code based on tree level.
                for (var i = 0; i < nodeDataArray.length; i++) {
                    var d = nodeDataArray[i];
                    if (d.key === "ROOT") {
                        d.category = "decision";
                        d.a = "A";
                        d.aText = "<?php echo $_SESSION['name']; ?>";
                        d.b = "B";
                        d.bText = "<?php echo $wife; ?>";
                    } else {
                        switch (d.key.length) {
                            case 1:
                                d.category = "decision";
                                d.a = "C";
                                d.aText = "Click here for see Grand child 1";
                                d.b = "D";
                                d.bText = "Click here for see Grand child 2";
                                break;
                            case 2:
                                d.category = "decision";
                                d.a = "T";
                                d.aText = "Thinking";
                                d.b = "F";
                                d.bText = "Feeling";
                                break;
                            default:
                                d.category = "personality";
                                break;
                        }
                    }
                }
                model.nodeDataArray = nodeDataArray;
            }
            // The key strings implicitly hold the relationship information, based on their spellings.
            // Other than the root node ("ROOT"), each node's key string minus its last letter is the
            // key to the "parent" node.
            function makeLinks(model) {
                var linkDataArray = [];
                var nda = model.nodeDataArray;
                for (var i = 0; i < nda.length; i++) {
                    var key = nda[i].key;
                    if (key === "ROOT" || key.length === 0)
                        continue;
                    // e.g., if key=="INTJ", we want: prefix="INT" and letter="J"
                    var prefix = key.slice(0, key.length - 1);
                    var letter = key.charAt(key.length - 1);
                    if (prefix.length === 0)
                        prefix = "ROOT";
                    var obj = {from: prefix, fromport: letter, to: key};
                    linkDataArray.push(obj);
                }
                model.linkDataArray = linkDataArray;
            }
        </script>
    </head>
    <body onload="init()">

        <nav class="navbar navbar-akash navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>

                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="home.php">
                        <img class="nav-img" src="images/logo.png" alt="" height="50px" width="150px;">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">

                    <ul class="nav navbar-nav navbar-right">

                        <li class=" "><a href="find.php">Find Relatives</a></li>
                        <li class=" "><a href="tree.php">Generations Tree</a></li>
                        <li class=" "><a href="profile.php"><?php echo $_SESSION['name']; ?> </a></li>
                        <li class=" "><a href="index.php">Logout</a></li>

                    </ul>
                </div>
            </div>
        </nav>

        <div id="sample">
            <div id="myDiagramDiv" style="background-color: white; border: solid 1px black; width: 100%; height: 500px"></div>
        </div>
    </body>
</html>
