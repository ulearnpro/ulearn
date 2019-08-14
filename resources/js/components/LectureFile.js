// TableRow.js

import React, { Component } from 'react';

export default class LectureFile extends Component {
  render() {
        return (
            <video controls>
              <source src={"http://bsetecdemo.com/expertplus/uploads/videos/"+this.props.greeting.subject+"/"+this.props.lecture} type="video/mp4" />
            </video>
        );
    }
}