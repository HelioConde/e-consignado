import type { Params } from './finance'
const DATABASE = 'e-consignado-educativo'
const STORE = 'simulations'
export type Saved = Params & { id: string; createdAt: string }
function openDB(): Promise<IDBDatabase> {
  return new Promise((resolve,reject)=>{
    if(!('indexedDB' in window)) return reject(new Error('IndexedDB indisponível neste navegador.'))
    const request=indexedDB.open(DATABASE,1)
    request.onupgradeneeded=()=>{if(!request.result.objectStoreNames.contains(STORE)) request.result.createObjectStore(STORE,{keyPath:'id'})}
    request.onsuccess=()=>resolve(request.result)
    request.onerror=()=>reject(request.error)
  })
}
async function operation<T>(mode:IDBTransactionMode,method:(s:IDBObjectStore)=>IDBRequest<T>):Promise<T> {
  const db=await openDB()
  try {return await new Promise<T>((resolve,reject)=>{
    const txn=db.transaction(STORE,mode),req=method(txn.objectStore(STORE))
    req.onsuccess=()=>resolve(req.result)
    req.onerror=()=>reject(req.error)
    txn.onerror=()=>reject(txn.error)
  })} finally{db.close()}
}
export async function listSaved():Promise<Saved[]> {
  const data=await operation('readonly',s=>s.getAll() as IDBRequest<Saved[]>)
  return data.sort((a,b)=>b.createdAt.localeCompare(a.createdAt))
}
export async function addSaved(params:Params):Promise<void>{
  const item:Saved={...params,id:crypto.randomUUID(),createdAt:new Date().toISOString()}
  await operation('readwrite',s=>s.put(item))
}
export async function removeSaved(id:string):Promise<void>{await operation('readwrite',s=>s.delete(id))}
export async function clearSaved():Promise<void>{await operation('readwrite',s=>s.clear())}
