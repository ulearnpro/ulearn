import React, { Component } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';


export default class Resource extends Component {
  lectureDescription(){
        if(this.props.lecture.description)
        {
            return (
                    <div>
                        <h5>Lecture Description</h5>
                        <div dangerouslySetInnerHTML={{ __html: this.props.lecture.description }} />
                    </div>
                );
        }
        
  }
  resourcesUL()
  {
    if(this.props.lecture.resources instanceof Array){
        return (
         <div>
         <h5>Downloadable Resources</h5>
         <ul className="list-group">
            {this.resourcesLI()}
         </ul>
         </div>
        );
    }
  }
  resourcesLI()
  {
        if(this.props.lecture.resources instanceof Array){
            return this.props.lecture.resources.map(function(resource, i){
                if(resource.file_type == 'link')
                {
                    return (
                        <li key={i} className="list-group-item">
                        <a href={resource.file_name} target="_blank">
                            <FontAwesomeIcon icon="external-link-alt" />&nbsp;
                            {resource.file_name}
                        </a>
                        </li>
                    );
                }
                else if(resource.file_type == 'pdf')
                {
                    return (
                        <li key={i} className="list-group-item">
                        <a href={ site_url+"/download-resource/"+resource.id+"/"+course_slug } target="_blank">
                            <FontAwesomeIcon icon="download" />&nbsp;
                            {resource.file_title}
                        </a>
                        </li>
                    );
                }
                
            });
        }
  }
  render() {
        return (
            <div>
                <button type="button" className="site-action-toggle btn-raised btn btn-success btn-floating" data-toggle="modal" data-target="#myModal">
                  <FontAwesomeIcon icon="download" />
                </button>

                <div className="modal" id="myModal">
                  <div className="modal-dialog  modal-lg">
                    <div className="modal-content">

                      
                      <div className="modal-header">
                        <h4 className="modal-title"><FontAwesomeIcon icon="paperclip" />&nbsp;Lecture Description & Resources</h4>
                        <button type="button" className="close" data-dismiss="modal">&times;</button>
                      </div>

                      
                      <div className="modal-body">
                        {this.lectureDescription()}
                        {this.resourcesUL()}
                        
                      </div>

                      
                      <div className="modal-footer">
                        <button type="button" className="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>

                    </div>
                  </div>
                </div>
            </div>
        );
    }
}

