import React from "react";
import LapIcon from "./../images/appleIcons/laptop.png";

function About(props) {
  let { resumeData } = props;
  return (
    <section id="about">
      <div className="row">
        <div className="three columns">
          <img className="profile-pic" src="images/profilepic.jpg" alt="" />
        </div>

        <div className="nine columns main-col">
          <div className="aboutBox">
            <h2>About Me</h2>
            <img src={LapIcon} alt="lap" width={70} />
          </div>
          <p>{resumeData.aboutme}</p>
        </div>
      </div>
    </section>
  );
}

export default About;
