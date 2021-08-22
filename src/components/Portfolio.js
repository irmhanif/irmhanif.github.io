import React, { useState } from "react";
import { Modal, Carousel, Tabs, Image, Row, Col } from "antd";
import ReactPlayer from "react-player";
import { BrowserRouter as Router, Link } from "react-router-dom";
import "antd/dist/antd.css";
import { FileImageOutlined, VideoCameraOutlined } from "@ant-design/icons";

export default function Portfolio(props) {
  let resumeData = props.resumeData;
  const { TabPane } = Tabs;
  const [poupState, setPoupState] = useState(false);
  const [position, setPosition] = useState(0)
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
    setTimeout(()=>{
      window.scrollTo(0, position)
    },0)
  };
  const renderPopup = () => {
    return (
      <Modal
        title={portfolio?.detailName || portfolio.name}
        visible={poupState}
        onOk={handleOk}
        footer={null}
        onCancel={handleCancel}
        width={1000}
      >
        <Row>
          <Col
            span={portfolio.demoVideo ? 8 : 6}
            xs={24}
            sm={24}
            lg={portfolio.demoVideo ? 8 : 6}
          >
            {/* <Carousel autoplay dots={{className:'dotsSlider'}} dotPosition={'right'}> */}
            {portfolio.demoVideo && portfolio.imgurl ? (
              <>
                <Tabs defaultActiveKey='2'>
                  <TabPane
                    tab={
                      <span>
                        <FileImageOutlined />
                        Images
                      </span>
                    }
                    key='1'
                  >
                    <Image
                      src={`${portfolio.imgurl}`}
                      alt={`${portfolio.imgurl}`}
                      className='item-img'
                    />
                  </TabPane>
                  <TabPane
                    tab={
                      <span>
                        <VideoCameraOutlined />
                        Video
                      </span>
                    }
                    key='2'
                  >
                    <ReactPlayer
                      className='react-player fixed-bottom'
                      url={portfolio.demoVideo}
                      width='100%'
                      height='100%'
                      controls={true}
                    />
                  </TabPane>
                </Tabs>
              </>
            ) : portfolio.demoVideo ? (
              <ReactPlayer
                className='react-player fixed-bottom'
                url={portfolio.demoVideo}
                width='100%'
                height='100%'
                controls={true}
              />
            ) : (
              <Image
                src={`${portfolio.imgurl}`}
                alt={`${portfolio.imgurl}`}
                className='item-img'
              />
            )}
            {/* </Carousel> */}
          </Col>
          <Col
            span={portfolio.demoVideo ? 16 : 18}
            xs={24}
            sm={24}
            lg={portfolio.demoVideo ? 16 : 18}
            className='popupDesc'
          >
            <p>{portfolio?.description}</p>
            {portfolio.web && (
              <>
                <Router>
                  Demo Link:{" "}
                  <Link to={{ pathname: portfolio.web }} target='_blank'>
                    {portfolio.web}
                  </Link>
                </Router>
              </>
            )}
            {portfolio?.responsiblities && (
              <div className='responsiblities'>
                <h5>
                  <u>Responsiblities: -</u>
                </h5>
                <ul>
                  {portfolio.responsiblities.map((response, index) => {
                    return <li key={index}>{response}</li>;
                  })}
                </ul>
              </div>
            )}
          </Col>
        </Row>
      </Modal>
    );
  };
  const settings = {
    dots: { className: "mainCarouselDots" },
    infinite: true,
    speed: 500,
    slidesToShow: 4,
    slidesToScroll: 4,
    arrows: true,
    draggable: true,
    variableWidth: true,
    initialSlide: 0,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: false,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          dots: false,
          slidesToScroll: 2,
          arrows: false,
          centerMode: true,
          initialSlide: 2,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          dots: false,
          centerMode: true,
          arrows: false,
          slidesToScroll: 1,
        },
      },
    ],
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
