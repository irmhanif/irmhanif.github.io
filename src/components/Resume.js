import React, { useState } from "react";
import resume from "./../documents/Mohamed Idris.pdf";
import { Button, Modal } from "antd";
import { DownloadOutlined, EyeOutlined } from "@ant-design/icons";
import PDFViewer from "pdf-viewer-reactjs";
import hereIcon from './../images/appleIcons/here.png'

export default function Resume(props) {
  let resumeData = props.resumeData;
  const [openPdf, setOpenPdf] = useState(false);
  const [position, setPosition] = useState(0);
  const openNew = () => {
    setOpenPdf(true);
    setPosition(window.pageYOffset);
  };
  const downloadNow = () => {
    window.open(resume, "_blank"); //to open new page
  };
  const handleCancel = () => {
    setOpenPdf(false);
    setTimeout(() => {
      window.scrollTo(0, position);
    }, 0);
  };
  return (
    <>
      <section id='resume'>
        <div className='row education'>
          <div className='three columns header-col'>
            <h1>
              <span>Education</span>
            </h1>
          </div>

          <div className='nine columns main-col'>
            {resumeData.education &&
              resumeData.education.map((item, index) => {
                return (
                  <div
                    className='row item'
                    id={`${item.UniversityName}${index}`}
                    key={`${item.UniversityName}${index}`}
                  >
                    <div className='twelve columns'>
                      <h3>{item.UniversityName}</h3>
                      <p className='info'>
                        {item.specialization}
                        <span>&bull;</span>{" "}
                        <em className='date'>
                          {item.MonthOfPassing} {item.YearOfPassing}
                        </em>
                      </p>
                      <p>{item.Achievements}</p>
                    </div>
                  </div>
                );
              })}
          </div>
        </div>
        <div className='row work'>
          <div className='three columns header-col'>
            <h1>
              <span>Work</span>
            </h1>
          </div>

          <div className='nine columns main-col'>
            {resumeData.work &&
              resumeData.work.map((item, index) => {
                return (
                  <div
                    className='row item'
                    id={`${item.CompanyName}${index}`}
                    key={`${item.CompanyName}${index}`}
                  >
                    <div className='twelve columns'>
                      <h3>{item.CompanyName}</h3>
                      <p className='info'>
                        {item.specialization}
                        <span>&bull;</span>{" "}
                        <em className='date'>{item.experience}</em>
                      </p>
                      <p>{item.Achievements}</p>
                    </div>
                  </div>
                );
              })}
          </div>
        </div>

        <div className='row skill'>
          <div className='three columns header-col '>
            <div className="skillHeading"><h1>
              <span>Skills</span>
            </h1>
            <img src={hereIcon} alt='here' width={100} /></div>
          </div>

          <div className='nine columns main-col'>
            <p>{resumeData.skillsDescription}</p>

            <div className='bars'>
              <ul className='skills'>
                {resumeData.skills &&
                  resumeData.skills.map((item, index) => {
                    return (
                      <li
                        id={`${item.CompanyName}${index}`}
                        key={`${item.CompanyName}${index}`}
                      >
                        <span
                          className={`bar-expand ${item.skillname.toLowerCase()}`}
                        />
                        <em>{item.skillname}</em>
                      </li>
                    );
                  })}
              </ul>
            </div>
          </div>
        </div>

        <div className='row skill'>
          <div className='three columns header-col'>
            <h1>
              <span>Resume</span>
            </h1>
          </div>

          <div className='nine columns main-col'>
            <Button
              type='primary'
              onClick={openNew}
              icon={<EyeOutlined />}
              size={"default"}
            >
              View
            </Button>{" "}
            <Button
              type='primary'
              onClick={downloadNow}
              icon={<DownloadOutlined />}
              size={"default"}
            >
              Download
            </Button>
          </div>
        </div>
      </section>
      {openPdf && (
        <Modal
          title={"Resume"}
          visible={openPdf}
          footer={null}
          onCancel={handleCancel}
          width={770}
          className='resumeModal'
        >
          <PDFViewer
            document={{
              url: "documents/Mohamed Idris.pdf",
            }}
            css='pdfViewerCss'
            canvasCss='canvasPdfCSs'
            hideRotation={true}
            hideZoom={true}
            scale={2}
          />
        </Modal>
      )}
    </>
  );
}
