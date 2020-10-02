on run theQuery
  tell application "Finder"
    set pathList to (quoted form of POSIX path of (folder of the front window as alias))
    set pathList to text -2 thru 2 of pathList
  end tell

  return pathList
end run