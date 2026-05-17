import type { Metadata } from "next";
import { Inter_Tight, JetBrains_Mono, Source_Serif_4 } from "next/font/google";
import "./globals.css";

const interTight = Inter_Tight({
  subsets: ["latin"],
  weight: ["400", "500", "600", "700", "800"],
  variable: "--font-inter-tight",
});

const jetbrainsMono = JetBrains_Mono({
  subsets: ["latin"],
  weight: ["400", "500", "600"],
  variable: "--font-jetbrains-mono",
});

const sourceSerif = Source_Serif_4({
  subsets: ["latin"],
  weight: ["400", "600"],
  variable: "--font-source-serif",
});

export const metadata: Metadata = {
  title: "Mohamed Idris — Senior React Developer",
  description:
    "Mohamed Idris — Senior React Developer, 7.5 years building enterprise apps at Comcast, Cognizant, Verizon and Walgreens.",
};

export default function RootLayout({
  children,
}: Readonly<{ children: React.ReactNode }>) {
  return (
    <html
      lang="en"
      data-theme="light"
      suppressHydrationWarning
      className={`${interTight.variable} ${jetbrainsMono.variable} ${sourceSerif.variable}`}
    >
      <head>
        <script
          dangerouslySetInnerHTML={{
            __html: `(function(){var t=localStorage.getItem('v4-theme');if(t)document.documentElement.setAttribute('data-theme',t);})();`,
          }}
        />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link
          href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,700;0,9..144,900;1,9..144,300;1,9..144,700&family=Cabinet+Grotesk:wght@300;400;500;600;700;800;900&family=Fira+Code:wght@300;400;500;600&display=swap"
          rel="stylesheet"
        />
        {/* Google tag (gtag.js) */}
        <Script
          src="https://www.googletagmanager.com/gtag/js?id=G-CXZC16CS4L"
          strategy="afterInteractive"
        />
        <Script id="google-analytics" strategy="afterInteractive">
          {`
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-CXZC16CS4L');
          `}
        </Script>
      </head>
      <body>{children}</body>
    </html>
  );
}
