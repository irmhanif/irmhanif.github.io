import React, { Component } from 'react';
export default class ContactUs extends Component {
  render() {
    let resumeData = this.props.resumeData;
    return (
      <section id="contact">
          <div className="row section-head">
            <div className="ten columns">
              <p className="lead">
              Feel free to contact me for any work or suggestions below
              </p>
            </div>
          </div>
          <div className="row">
            <aside className="eigth columns footer-widgets">
              <div className="widget">
                <h4>Mail Id :
                  <a href={resumeData.mailIdurl} id={resumeData.mailId} target='_blank' rel="noopener noreferrer">{resumeData.mailId}</a>
                </h4>
              </div>
            </aside>
          </div>
        </section>
        );
  }
}