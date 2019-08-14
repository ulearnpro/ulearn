// TableRow.js

import React, { Component } from 'react';
import { BrowserRouter as Router, Route, NavLink, Link } from "react-router-dom";

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

export default class SideItem extends Component {
  render() {
    const is_section = this.props.lecture.is_section;
    if(is_section) {
        return (
         <li className="site-menu-category">Section {this.props.lecture.number} - {this.props.lecture.s_title}</li>
        );
    } else {
        return (
        <li className="site-menu-item">
            <NavLink to={base_url+"/"+this.props.lecture.url} activeClassName="active">
            <article>
                <FontAwesomeIcon icon="angle-double-right" />&nbsp;
                <span>Lecture {this.props.lecture.number}: {this.props.lecture.l_title}</span>
            </article>
            </NavLink>
        </li>
        );
    }
    }
}