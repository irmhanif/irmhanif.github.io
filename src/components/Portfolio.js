import React, { Component } from 'react';
export default class Porfolio extends Component {
  render() {
    let resumeData = this.props.resumeData;
    
    return (
      <section id="portfolio">
      <div className="row">
        <div className="twelve columns ">
          <h1>Check Out Some of My Works.</h1>
          <div id="portfolio-wrapper" className="bgrid-quarters s-bgrid-thirds cf">
          {
            resumeData.portfolio && resumeData.portfolio.map((item, index)=>{
              return(
                <div className="columns portfolio-item" id={`${item.name}${index}`}>
                  <div className="item-wrap">
                    <a href={item.web} className='open_tag' target='_blank' rel="noopener noreferrer">
                      <img src={`${item.imgurl}`} alt={`${item.imgurl}`} className="item-img"/>
                      <div className="overlay">
                        <div className="portfolio-item-meta">
                          <h5>{item.name}</h5>
                          <p>{item.description}</p>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              )
            })
          }
          </div>
        </div>
      </div>
  </section>
        );
  }
}