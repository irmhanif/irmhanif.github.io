import React, { useState } from "react";
import { Carousel } from "antd";
import "antd/dist/antd.css";
import Popup from "../componentFeatures/Popup";
import { settings } from "../utility";

export default function Portfolio(props) {
  let resumeData = props.resumeData;
  const [poupState, setPoupState] = useState(false);
  const [position, setPosition] = useState(0);
  const [portfolio, setPortfolio] = useState({});
  const handlePopUp = (item) => {
    setPoupState(true);
    setPosition(window.pageYOffset)
    setPortfolio(item);
  };
  const handleOk = () => {
    setPoupState(false);
  };

  const handleCancel = () => {
    setPoupState(false);
    setTimeout(() => {
      window.scrollTo(0, position);
    }, 0);
  };
  const renderPopup = () => {
    return (
      <Popup
        width={1000}
        portfolio={portfolio}
        isOpen={poupState}
        handleOk={handleOk}
        footer={null}
        handleCancel={handleCancel}
      />
    );
  };
  

  return (
    <>
      {poupState && renderPopup()}
      <section id='portfolio'>
        <div className='row'>
          <div className='twelve columns place_center'>
            <h1>Check Out Some of My Works.</h1>
            <div id='portfolio-wrapper' className='s-bgrid-thirds cf'>
              <Carousel
                {...settings}
                //dots={{className: 'mainCarouselDots'}}
                className='mainCarousel'
              >
                {resumeData.portfolio &&
                  resumeData.portfolio.map((item, index) => {
                    return (
                      <div
                        onClick={(e) => handlePopUp(item)}
                        className='columns portfolio-item'
                        id={`${item.name}${index}`}
                        key={`${item.name}${index}`}
                      >
                        <div className='item-wrap'>
                          <img
                            src={`${item.imgurl}`}
                            alt={`${item.imgurl}`}
                            className='item-img'
                          />
                          <div className='overlay'>
                            <div className='portfolio-item-meta'>
                              <h5>{item.name}</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    );
                  })}
              </Carousel>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
