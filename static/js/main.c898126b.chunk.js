(window.webpackJsonp=window.webpackJsonp||[]).push([[0],{11:function(e,a,t){e.exports=t.p+"static/media/Web Developer.b76c93b0.pdf"},15:function(e,a,t){e.exports=t(35)},20:function(e,a,t){},35:function(e,a,t){"use strict";t.r(a);var n=t(0),l=t.n(n),r=t(10),i=t.n(r),s=(t(20),t(1)),o=t(2),c=t(4),m=t(3),u=t(5),p=function(e){function a(){return Object(s.a)(this,a),Object(c.a)(this,Object(m.a)(a).apply(this,arguments))}return Object(u.a)(a,e),Object(o.a)(a,[{key:"render",value:function(){var e=this.props.resumeData;return l.a.createElement(l.a.Fragment,null,l.a.createElement("header",{id:"home"},l.a.createElement("nav",{id:"nav-wrap"},l.a.createElement("a",{className:"mobile-btn",href:"#nav-wrap",title:"Show navigation"},"Show navigation"),l.a.createElement("ul",{id:"nav",className:"nav"},l.a.createElement("li",{className:"current"},l.a.createElement("a",{className:"smoothscroll",href:"#home"},"Home")),l.a.createElement("li",null,l.a.createElement("a",{className:"smoothscroll",href:"#about"},"About")),l.a.createElement("li",null,l.a.createElement("a",{className:"smoothscroll",href:"#resume"},"CV")),l.a.createElement("li",null,l.a.createElement("a",{className:"smoothscroll",href:"#portfolio"},"Works")),l.a.createElement("li",null,l.a.createElement("a",{className:"smoothscroll",href:"#contact"},"Contact")))),l.a.createElement("div",{className:"row banner"},l.a.createElement("div",{className:"banner-text"},l.a.createElement("h1",{className:"responsive-headline"},"I am ",e.name,". "),l.a.createElement("h3",{style:{color:"#fff",fontFamily:"sans-serif "}},"I am a ",e.role,". ",e.roleDescription),l.a.createElement("hr",null),l.a.createElement("ul",{className:"social"},e.socialLinks&&e.socialLinks.map(function(e){return l.a.createElement("li",{key:e.name},l.a.createElement("a",{href:e.url,target:"_blank",rel:"noopener noreferrer"},l.a.createElement("i",{className:e.className})))})))),l.a.createElement("p",{className:"scrolldown"},l.a.createElement("a",{className:"smoothscroll",href:"#about"},l.a.createElement("i",{className:"icon-down-circle"})))))}}]),a}(n.Component),d=function(e){function a(){return Object(s.a)(this,a),Object(c.a)(this,Object(m.a)(a).apply(this,arguments))}return Object(u.a)(a,e),Object(o.a)(a,[{key:"render",value:function(){var e=this.props.resumeData;return l.a.createElement("section",{id:"about"},l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"three columns"},l.a.createElement("img",{className:"profile-pic",src:"images/profilepic.jpg",alt:""})),l.a.createElement("div",{className:"nine columns main-col"},l.a.createElement("h2",null,"About Me"),l.a.createElement("p",null,e.aboutme),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"columns contact-details"},l.a.createElement("h2",null,"Contact Details"),l.a.createElement("p",{className:"address"},l.a.createElement("span",null,e.name),l.a.createElement("br",null),l.a.createElement("span",null,e.address),l.a.createElement("br",null),l.a.createElement("span",null,l.a.createElement("a",{href:e.contactTell},e.contact))))))))}}]),a}(n.Component),h=t(12),E=t.n(h),v=t(11),f=t.n(v),b=function(e){function a(e){var t;return Object(s.a)(this,a),(t=Object(c.a)(this,Object(m.a)(a).call(this,e))).state={},t}return Object(u.a)(a,e),Object(o.a)(a,[{key:"openNew",value:function(){window.open(f.a,"_blank")}},{key:"render",value:function(){var e=this.props.resumeData;return l.a.createElement("section",{id:"resume"},l.a.createElement("div",{className:"row education"},l.a.createElement("div",{className:"three columns header-col"},l.a.createElement("h1",null,l.a.createElement("span",null,"Education"))),l.a.createElement("div",{className:"nine columns main-col"},e.education&&e.education.map(function(e,a){return l.a.createElement("div",{className:"row item",id:"".concat(e.UniversityName).concat(a)},l.a.createElement("div",{className:"twelve columns"},l.a.createElement("h3",null,e.UniversityName),l.a.createElement("p",{className:"info"},e.specialization,l.a.createElement("span",null,"\u2022")," ",l.a.createElement("em",{className:"date"},e.MonthOfPassing," ",e.YearOfPassing)),l.a.createElement("p",null,e.Achievements)))}))),l.a.createElement("div",{className:"row work"},l.a.createElement("div",{className:"three columns header-col"},l.a.createElement("h1",null,l.a.createElement("span",null,"Work"))),l.a.createElement("div",{className:"nine columns main-col"},e.work&&e.work.map(function(e,a){return l.a.createElement("div",{className:"row item",id:"".concat(e.CompanyName).concat(a)},l.a.createElement("div",{className:"twelve columns"},l.a.createElement("h3",null,e.CompanyName),l.a.createElement("p",{className:"info"},e.specialization,l.a.createElement("span",null,"\u2022")," ",l.a.createElement("em",{className:"date"},e.experience)),l.a.createElement("p",null,e.Achievements)))}))),l.a.createElement("div",{className:"row skill"},l.a.createElement("div",{className:"three columns header-col"},l.a.createElement("h1",null,l.a.createElement("span",null,"Skills"))),l.a.createElement("div",{className:"nine columns main-col"},l.a.createElement("p",null,e.skillsDescription),l.a.createElement("div",{className:"bars"},l.a.createElement("ul",{className:"skills"},e.skills&&e.skills.map(function(e,a){return l.a.createElement("li",{id:"".concat(e.skillname).concat(a)},l.a.createElement("span",{className:"bar-expand ".concat(e.skillname.toLowerCase())}),l.a.createElement("em",null,e.skillname))}))))),l.a.createElement("div",{className:"row skill"},l.a.createElement("div",{className:"three columns header-col"},l.a.createElement("h1",null,l.a.createElement("span",null,"Resume"))),l.a.createElement("div",{className:"nine columns main-col"},l.a.createElement("button",{onClick:this.openNew},"View ",l.a.createElement(E.a,null)))))}}]),a}(n.Component),g=function(e){function a(){return Object(s.a)(this,a),Object(c.a)(this,Object(m.a)(a).apply(this,arguments))}return Object(u.a)(a,e),Object(o.a)(a,[{key:"render",value:function(){var e=this.props.resumeData;return l.a.createElement("section",{id:"portfolio"},l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"twelve columns place_center"},l.a.createElement("h1",null,"Check Out Some of My Works."),l.a.createElement("div",{id:"portfolio-wrapper",className:"carousel s-bgrid-thirds cf"},e.portfolio&&e.portfolio.map(function(e,a){return l.a.createElement("div",{className:"columns portfolio-item",id:"".concat(e.name).concat(a)},l.a.createElement("div",{className:"item-wrap"},l.a.createElement("a",{href:e.web,className:"open_tag",target:"_blank",rel:"noopener noreferrer"},l.a.createElement("img",{src:"".concat(e.imgurl),alt:"".concat(e.imgurl),className:"item-img"}),l.a.createElement("div",{className:"overlay"},l.a.createElement("div",{className:"portfolio-item-meta"},l.a.createElement("h5",null,e.name),l.a.createElement("p",null,e.description))))))})))))}}]),a}(n.Component),w=function(e){function a(){return Object(s.a)(this,a),Object(c.a)(this,Object(m.a)(a).apply(this,arguments))}return Object(u.a)(a,e),Object(o.a)(a,[{key:"render",value:function(){var e=this.props.resumeData;return l.a.createElement("section",{id:"contact"},l.a.createElement("div",{className:"row section-head"},l.a.createElement("div",{className:"ten columns"},l.a.createElement("p",{className:"lead"},"Feel free to contact me for any work or suggestions below"))),l.a.createElement("div",{className:"row"},l.a.createElement("aside",{className:"eigth columns footer-widgets"},l.a.createElement("div",{className:"widget"},l.a.createElement("h4",null,"Mail Id :",l.a.createElement("a",{href:e.mailIdurl,id:e.mailId,target:"_blank",rel:"noopener noreferrer"},e.mailId))))))}}]),a}(n.Component),N=function(e){function a(){return Object(s.a)(this,a),Object(c.a)(this,Object(m.a)(a).apply(this,arguments))}return Object(u.a)(a,e),Object(o.a)(a,[{key:"render",value:function(){var e=this.props.resumeData;return l.a.createElement("footer",null,l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"twelve columns"},l.a.createElement("ul",{className:"social-links"},e.socialLinks&&e.socialLinks.map(function(e){return l.a.createElement("li",null,l.a.createElement("a",{href:e.url},l.a.createElement("i",{className:e.className})))}))),l.a.createElement("div",{id:"go-top"},l.a.createElement("a",{className:"smoothscroll",title:"Back to Top",href:"#home"},l.a.createElement("i",{className:"icon-up-open"})))))}}]),a}(n.Component),k={imagebaseurl:"https://avatars2.githubusercontent.com/u/19489199?s=460&v=4",name:"Mohamed Idris M",role:"Full Stack Developer",mailId:" idrishan1996@gmail.com",mailIdurl:"https://mail.google.com/mail/u/0/?view=cm&fs=1&to=idrishan1996@gmail.com&tf=1",skypeid:"Your skypeid",roleDescription:"Experienced Web Developer in the information technology and services industry. Strong professional skilled in JavaScript, PHP, SQL, jQuery, Web Development and Responsive Web Development with Bootstrap. I like dabbling in various parts of frontend and backend development.",socialLinks:[{name:"linkedin",url:"https://in.linkedin.com/in/idris-webdeveloper",className:"fa fa-linkedin"},{name:"github",url:"https://github.com/irmhanif",className:"fa fa-github"}],aboutme:"I am currently a web developer at Zinavo Technology. I am a self taught Full Stack Web Developer using PHP, currently learning MERN stack development. Strong professional skilled in JavaScript, PHP, SQL, jQuery, Web Development and Responsive Web Development with Bootstrap.",address:"India",website:"http://irmhanif.github.io/",contact:"idrishan1996@gmail.com",contactTell:"mailto:idrishan1996@gmail.com",education:[{UniversityName:"Jamal Mohamed College, Trichy",specialization:"Computer Sciene",MonthOfPassing:"April",YearOfPassing:"2018"}],work:[{CompanyName:"Zinavo",specialization:"Front End, PHP, JS & Joomla(CMS)",experience:"2 Years 1 Month"}],skillsDescription:"Strong professional skilled in JavaScript, PHP, SQL, jQuery, Web Development and Responsive Web Development with Bootstrap.",skills:[{skillname:"Reactjs"},{skillname:"HTML5"},{skillname:"CSS"},{skillname:"Javascript"},{skillname:"PHP"},{skillname:"Joomla"}],resumeFile:"document/Web Developer.pdf",portfolio:[{name:"France by French",description:"Tourism web application with different kind of trips with admin panel to manage bookings & also having different kind of payment methods like single payment & share pay.",imgurl:"images/portfolio/fbf.png",web:"https://www.francebyfrench.com/"},{name:"Wed on Set",description:"Web application for booking wedding service's in limited Cities, in catering service you can choose food items. Under working",imgurl:"images/portfolio/wod.png",web:"http://zinavo-clientupdates.in/idris/wedonset/"},{name:"Vibhive",description:"Web application for interior designing with 360\xb0 video's and Having pie chart user dashboard for quotations based on your request",imgurl:"images/portfolio/vs.png",web:"https://www.vstudioz.in/"},{name:"GME",description:"Dynamic website for Man power supplying agency for various services. ",imgurl:"images/portfolio/gme.png",web:"http://globalmgm.com/"},{name:"Bigcollege",description:"In this website you can find list of college's. Here you can do registration and User access to add or customize thier own colleges",imgurl:"images/portfolio/bc.png",web:"https://www.bigcollege.in/"},{name:"Movie Browser",description:"Progressive web app build using React Js. Movie browser, used OMDB API to get movie's data",imgurl:"images/portfolio/mb.png",web:"https://pwapp-reactjs.web.app/"},{name:"Group Chat",description:"Chat room build using React Js, Firebase, React Hooks and Google Login authentication. UI based on Whatsapp",imgurl:"images/portfolio/gc.png",web:"https://whats-app-cloneapp.web.app/"},{name:"Todo App",description:"Basic todo app build with React Js and Used Sass  ",imgurl:"images/portfolio/td.png",web:"https://irmhanif.github.io/todo.html"}],testimonials:[{description:"This is a sample testimonial",name:"Some technical guy"},{description:"This is a sample testimonial",name:"Some technical guy"}]},y=function(e){function a(){return Object(s.a)(this,a),Object(c.a)(this,Object(m.a)(a).apply(this,arguments))}return Object(u.a)(a,e),Object(o.a)(a,[{key:"render",value:function(){return l.a.createElement("div",{className:"App"},l.a.createElement(p,{resumeData:k}),l.a.createElement(d,{resumeData:k}),l.a.createElement(b,{resumeData:k}),l.a.createElement(g,{resumeData:k}),l.a.createElement(w,{resumeData:k}),l.a.createElement(N,{resumeData:k}))}}]),a}(n.Component);Boolean("localhost"===window.location.hostname||"[::1]"===window.location.hostname||window.location.hostname.match(/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/));i.a.render(l.a.createElement(y,null),document.getElementById("root")),"serviceWorker"in navigator&&navigator.serviceWorker.ready.then(function(e){e.unregister()})}},[[15,2,1]]]);
//# sourceMappingURL=main.c898126b.chunk.js.map