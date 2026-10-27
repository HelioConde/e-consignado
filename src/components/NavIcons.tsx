import type { ReactNode } from 'react'

export type NavIconName = 'overview' | 'calculator' | 'percent' | 'compare' | 'tools' | 'help' | 'shield' | 'menu' | 'close'

/** Small inline SVG icon set: consistent 24px grid, no icon fonts or external requests. */
export function NavIcon({name,size=20,className=''}:{name:NavIconName;size?:number;className?:string}) {
  let graphic: ReactNode
  switch(name){
    case 'overview':
      graphic=<><rect x="3" y="3.5" width="7" height="7" rx="1.7"/><rect x="14" y="3.5" width="7" height="7" rx="1.7"/><rect x="3" y="14.5" width="7" height="6" rx="1.7"/><rect x="14" y="14.5" width="7" height="6" rx="1.7"/></>
      break
    case 'calculator':
      graphic=<><rect x="5" y="2.5" width="14" height="19" rx="2.5"/><path d="M8 7h8M8.5 11h1M14.5 11h1M8.5 15h1M14.5 15h1M8.5 19h1M14.5 19h1"/></>
      break
    case 'percent':
      graphic=<><circle cx="7.5" cy="7.5" r="2"/><circle cx="16.5" cy="16.5" r="2"/><path d="M19 5 5 19"/></>
      break
    case 'compare':
      graphic=<><path d="M4 7h16m0 0-4-4m4 4-4 4M20 17H4m0 0 4-4m-4 4 4 4"/></>
      break
    case 'tools':
      graphic=<><rect x="3.5" y="6.5" width="17" height="14" rx="2"/><path d="M9 6V4.5A1.5 1.5 0 0 1 10.5 3h3A1.5 1.5 0 0 1 15 4.5V6M3.5 12.5c4.5 3 12.5 3 17 0M10 13.5h4"/></>
      break
    case 'help':
      graphic=<><circle cx="12" cy="12" r="9.5"/><path d="M9.5 9.3a2.8 2.8 0 0 1 5.2 1.4c0 1.9-2.7 2.3-2.7 4.5"/><path d="M12 18h.01"/></>
      break
    case 'shield':
      graphic=<><path d="M12 2.8 20 6v5.7c0 5.2-3.3 8.5-8 10-4.7-1.5-8-4.8-8-10V6l8-3.2Z"/><path d="m8.5 12 2.4 2.3 4.6-4.7"/></>
      break
    case 'menu':
      graphic=<path d="M4 6h16M4 12h16M4 18h16"/>
      break
    case 'close':
      graphic=<path d="M5 5 19 19M19 5 5 19"/>
      break
  }
  return <svg className={className} xmlns="http://www.w3.org/2000/svg" width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true" focusable="false">{graphic}</svg>
}

/** The same vector silhouette is used by the site favicon. */
export function BrandMark() {
  return <svg className="brand-symbol" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="46" height="46" aria-hidden="true" focusable="false">
    <defs><linearGradient id="brand-gradient" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stopColor="#1d625f"/><stop offset="100%" stopColor="#102b3f"/></linearGradient></defs>
    <rect x="1" y="1" width="62" height="62" rx="17" fill="url(#brand-gradient)" stroke="#66c9b2" strokeOpacity=".5" strokeWidth="1.5"/>
    <path d="M44 31.8c0-8.7-6.2-14.5-15.3-14.5a15.3 15.3 0 1 0 12.3 24.2" fill="none" stroke="#b3ffe7" strokeWidth="6" strokeLinecap="round"/>
    <path d="M15.2 31.8H44" fill="none" stroke="#b3ffe7" strokeWidth="6" strokeLinecap="round"/>
    <circle cx="47" cy="47" r="4" fill="#69e7ce"/>
  </svg>
}
