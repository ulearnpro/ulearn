
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
require('./components/TopBar');

import React from 'react';
import { render } from 'react-dom';
import { BrowserRouter as Router, Route } from "react-router-dom";
import 'bootstrap/dist/css/bootstrap.css';
import './site.css';

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faAngleDoubleRight, faCheck, faArrowLeft, faDownload, faPaperclip, faExternalLinkAlt } from '@fortawesome/free-solid-svg-icons';

library.add(faAngleDoubleRight, faCheck, faArrowLeft, faDownload, faPaperclip, faExternalLinkAlt);


import Master from './components/Master';
import Footer from './components/Footer';

render(
    <Router >
        <Route path={base_url+"/:l_slug"} component={Master} />
     </Router>,
  document.getElementById('course-enroll-container')
);