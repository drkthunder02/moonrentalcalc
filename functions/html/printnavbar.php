<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function PrintNavBar() {
    printf("<nav class=\"navbar navbar-dark bg-dark\">");
    printf("<button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarNav\" aria-controls=\"navbarNav\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">");
    printf("<span class=\"navbar-toggler-icon\"></span>");
    printf("</button>");
    printf("<div class=\"collapse navbar-collapse\" id=\"navbarNav\">");
    printf("<ul class=\"navbar-nav mr-auto\">");
    printf("<li class=\"nav-item\"><a class=\"nav-link\" href=\"index.php\">Home</a></li>");
    printf("<li class=\"nav-item\"><a class=\"nav-link\" href=\"spatial.php\">Rental Moons</a></li>");
    printf("</ul>");
    printf("</div>");
    printf("</nav>");
}
