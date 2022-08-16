import React, { FC } from 'react';

interface LayoutProps {
  children: React.ReactNode;
}

const Layout: FC<LayoutProps> = ({ children, ...props }) => {

  return(
    <>
      <main role={ 'main' } >
        <div>
        { children }
        </div>
      </main>
    </>
  )
}


export default Layout;
