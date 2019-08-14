import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import TopBar from '../components/TopBar';
import SideBar from '../components/SideBar';
import CourseContent from '../components/CourseContent';
import Resource from '../components/Resource';


export default class Master extends Component {
    constructor(props) {
       super(props);
       this.state = {sections: [],lecture_detail: []};
    }
    componentDidMount(){
        const { l_slug } = this.props.match.params;
        const is_sidebar = true;
        this.fetchLectureDetails(l_slug, is_sidebar);
    }
    componentWillReceiveProps(nextProps) {
        const is_sidebar = false;
        if(this.props.match.params.l_slug !== nextProps.match.params.l_slug) {
            this.fetchLectureDetails(nextProps.match.params.l_slug, is_sidebar);
        }
    }
    fetchLectureDetails(l_slug, is_sidebar)
    {
        if(is_sidebar)
        {
            axios.get(site_url+'/course-enroll-api/'+course_slug+'/'+l_slug+'/'+is_sidebar)
           .then(response => {
                this.setState({ sections: response.data.sections,lecture_detail: response.data.lecture_details });
                console.log(this.state);
           })
            .catch(function (error) {
                console.log(error);
                return window.location.href = site_url+'/login';
            })
        } else {
            axios.get(site_url+'/course-enroll-api/'+course_slug+'/'+l_slug+'/'+is_sidebar)
           .then(response => {
                this.setState({ lecture_detail: response.data.lecture_details });
                console.log(this.state);
           })
            .catch(function (error) {
                console.log(error);
                return window.location.href = site_url+'/login';
            })
        }
        
    }
    render() {
        return (
            <div>
                <div id="top-bar">
                    <TopBar />
                </div>
                <div className="site-menubar" id="site-menubar">
                    <SideBar sections={this.state.sections} />
                </div>
                <div className="page">
                    <CourseContent lecture={this.state.lecture_detail} />
                </div>
                <div className="site-action">
                    <Resource lecture={this.state.lecture_detail}/>
                </div>
            </div>
        );
    }
}

