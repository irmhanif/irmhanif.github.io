import React, { Component } from 'react';
import LapIcon from './../images/appleIcons/laptop.png'
import CallWhiteIcon from './../images/appleIcons/callWhite.png'
export default class About extends Component {
  render() {
    let resumeData = this.props.resumeData;
    return <section id="about">
        <div className="row">
          <div className="three columns">
            <img className="profile-pic" src="images/profilepic.jpg" alt="" />
          </div>

          <div className="nine columns main-col">
            <div className='aboutBox'><h2>About Me</h2><img src={LapIcon} alt='lap' width={70} /></div>
            <p>{resumeData.aboutme}</p>

            <div className="row">
              <div className="columns contact-details">
                <div className='aboutBox'><h2>Contact Details</h2><img src={CallWhiteIcon} alt='lap' width={70} /></div>
                <p className="address">
                  <span>{resumeData.name}</span>
                  <br />
                  <span>{resumeData.address}</span>
                  <br />
                  <span>
                    <a href={resumeData.contactTell}>{resumeData.contact}</a>
                  </span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>;
  }
}