import React from "react";
import { Modal, Carousel, Tabs, Image, Row, Col } from "antd";
import { FileImageOutlined, VideoCameraOutlined } from "@ant-design/icons";
import ReactPlayer from "react-player";
import { BrowserRouter as Router, Link } from "react-router-dom";
import { importAll, settings } from "./../utility";
import style from "./Popup.module.scss";
import "./Popup.scss";

export default function Popup(props) {
  const {
    portfolio,
    isOpen,
    handleOk,
    handleCancel,
    width = "500",
    footer,
  } = props;
  const { TabPane } = Tabs;

  const handleOkBtn = () => {
    handleOk && handleOk();
  };
  const handleCancelBtn = () => {
    handleCancel && handleCancel();
  };

  const renderImages = (folder) => {
    let images = [];
    if (folder === "fbf") {
      images = importAll(
        require.context(`./../images/fbf`, false, /\.(png|jpe?g|svg)$/)
      );
    } else if (folder === "bio") {
      images = importAll(
        require.context(`./../images/bio`, false, /\.(png|jpe?g|svg)$/)
      );
    } else if (folder === "wos") {
      images = importAll(
        require.context(`./../images/wos`, false, /\.(png|jpe?g|svg)$/)
      );
    }
    return Object.values(images).map((img) => {
      console.log(img);
      return (
        <Image
          src={img}
          alt={img}
          width='200'
          height='100'
          className={style.dispImage}
          style={{ backgroundImage: `url('${img}')` }}
        />
      );
    });
  };
  return (
    <Modal
      title={portfolio?.detailName || portfolio.name}
      visible={isOpen}
      onOk={handleOkBtn}
      footer={footer}
      onCancel={handleCancelBtn}
      width={width}
    >
      <Row>
        <Col
          span={portfolio.demoVideo ? 8 : 6}
          xs={24}
          sm={24}
          lg={portfolio.demoVideo ? 8 : 6}
        >
          {portfolio.demoVideo && portfolio.folder ? (
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
                  {portfolio?.folder ? (
                    <div className={style.imageContainer}>
                      {renderImages(portfolio?.folder)}
                    </div>
                  ) : (
                    <Image
                      src={`${portfolio.imgurl}`}
                      alt={`${portfolio.imgurl}`}
                      className='item-img'
                    />
                  )}
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
          ) : portfolio.folder ? (
            <div className={style.imageContainer}>
              {renderImages(portfolio?.folder)}
            </div>
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
}
