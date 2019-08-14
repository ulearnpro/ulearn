import React, {Component} from 'react';
import { render } from 'react-dom';
import axios from 'axios';
import { BrowserRouter as Router, Route, NavLink, Link } from "react-router-dom";

import SideItem from '../components/SideItem';

export default class SideBar extends Component {
    sideItem(){
       if(this.props.sections instanceof Array){
         return this.props.sections.map(function(lecture, i){
            return <SideItem lecture={lecture} key={i} />;
         })
       }
     }
    render() {
        return (
            <div className="site-menubar-body">
                <ul className="site-menu">
                    {this.sideItem()}
                </ul>
            </div>
        );
    }
}

