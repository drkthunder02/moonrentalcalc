<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function PrintNavBar() {
    printf("<nav class=\"navbar navbar-dark bg-dark\">");
    printf("<a class=\"navbar-brand\" href=\"#\">W4RP Moon Rental Calculator</a>");
    printf("<div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">");
    printf("<ul class=\"navbar-nav mr-auto\">");
    printf("<li class=\"nav-item\"><a class=\"nav-link\" href=\"index.php\">Home</a></li>");
    printf("<li class=\"nav-item\"><a class=\"nav-link\" href=\"spatial.php\">Rental Moons</a></li>");
    printf("</ul>");
    printf("</div>");
    printf("</nav>");
}
